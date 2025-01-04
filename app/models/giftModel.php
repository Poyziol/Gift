<?php

namespace App\Models;

use PDO;
use Flight;

class GiftModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * ---------------------------
     * SELECT statement
     * ---------------------------
     */
    public function getAvailableGifts()
    {
        $query = "  SELECT 
                        * -- g.id_gift, g.name, g.montant, g.description, g.stock_quantity, g.pic, c.categorie_name 
                    FROM 
                        gift_gift g
                    LEFT JOIN 
                        gift_categorie c 
                    ON 
                        g.id_categorie = c.id_categorie
                    WHERE 
                        g.stock_quantity > 0    
                  ";
        $STH = $this->db->prepare($query);
        $STH->execute();
        return $STH->fetchAll(PDO::FETCH_ASSOC);
    }

    // Purchased gifts by an user
    public function getPurchasedGifts($userId)
    {
        $query = "  SELECT 
                        g.id_gift, g.name, g.montant, g.description, g.pic, t.quantity
                    FROM
                        gift_choice t
                    JOIN
                        gift_gift g ON t.id_gift = g.id_gift
                    WHERE
                        t.id_user = :userId
    ";

        $STH = Flight::db()->prepare($query);
        $STH->execute(['userId' => $userId]);
        return $STH->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ---------------------------
     * Used by the DashboardController
     * ---------------------------
     */
    public function getGiftSuggestions($boys, $girls)
    {
        $balance = Flight::userModel()->getActualUserBalance();
        $suggestions = [];
        $remainingBalance = $balance;
        $totalChildren = $boys + $girls;
        if ($totalChildren === 0 || $remainingBalance <= 0)
            return [];

        // Boys
        for ($i = 0; $i < $boys; $i++) {
            $randomBalance = rand(1, floor($remainingBalance)); // No float problem
            $gift = $this->getGift([2, 3], $randomBalance);
            if ($gift) {
                $suggestions[] = $gift;
                $remainingBalance -= $gift['montant'];
            }
        }

        // Girs
        for ($i = 0; $i < $girls; $i++) {
            $randomBalance = rand(1, floor($remainingBalance));
            $gift = $this->getGift([1, 3], $randomBalance);
            if ($gift) {
                $suggestions[] = $gift;
                $remainingBalance -= $gift['montant'];
            }
        }

        // In case of rest 
        $leftoverChildren = $boys + $girls - count($suggestions);
        while ($remainingBalance > 0 && $leftoverChildren > 0) {
            $maxmontant = floor($remainingBalance / $leftoverChildren);

            // Attempt to allocate additional gifts
            $additionalGift = $this->getGift([1, 2, 3], $maxmontant);
            if ($additionalGift) {
                $suggestions[] = $additionalGift;
                $remainingBalance -= $additionalGift['montant'];
                $leftoverChildren--;
            } else {
                // Break if no suitable gift is found 
                break;
            }
        }

        // Add column INDEX and store with sesssion to make it replacable after
        $i = 0;
        $suggestions = array_map(function ($suggestion) use (&$i) {
            $suggestion['index'] = $i++;
            return $suggestion;
        }, $suggestions);

        return $suggestions;
    }

    // Helper method for getGiftSuggestions
    function getGift($categories, $maxmontant)
    {
        $categorieCondition = implode(' OR ', array_map(function ($id) {
            return "id_categorie = $id";
        }, $categories));
        $query = "  SELECT  
                        * 
                    FROM
                        gift_gift
                    WHERE 
                        ($categorieCondition) AND stock_quantity > 0 AND montant <= $maxmontant
                    ORDER BY 
                        RAND()
                    LIMIT 1
      ";

        $STH = $this->db->query($query);
        return $STH->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * ---------------------------
     * Proper operations
     * ---------------------------
     */

    public function replaceGift($index, &$suggestions)// Adress so that the session can also change
    {
        $oldGift = $suggestions[$index];
        $categorieId = $oldGift['id_categorie'];

        // Calculate the remaining balance and total amount
        $balanceData = $this->getRemainingBalanceAndTotal($suggestions);
        $remainingBalance = $balanceData['remaining_balance'];

        // Fetch a new gift in the same categorie and within the remaining balance
        $query = "  SELECT 
                        * 
                    FROM 
                        gift_gift
                    WHERE 
                        id_categorie = $categorieId AND stock_quantity > 0 AND montant <= $remainingBalance AND id_gift != {$oldGift['id_gift']}
                    ORDER BY 
                        RAND()
                    LIMIT 1
    ";
        $newGift = $this->db->query($query)->fetch(PDO::FETCH_ASSOC);

        if (!$newGift) 
            return ['error' => 'No suitable replacement gift found'];

        $suggestions[$index] = $newGift;
        $newGift['index'] = $index; // Add the column index to the new gift

        return $newGift;
    }

    public function getRemainingBalanceAndTotal($suggestions)
    {
        $totalAmount = 0;

        foreach ($suggestions as $gift) {
            $totalAmount += $gift['montant'];
        }

        $remainingBalance = Flight::userModel()->getActualUserBalance();

        return [
            'total_amount' => $totalAmount,
            'remaining_balance' => $remainingBalance - $totalAmount
        ];
    }

    // The final thing to do
    public function finalizeSelections($userId, $suggestions)
    {

        // Too lazy to do prepare and exec
        foreach ($suggestions as $gift) {
            $id_gift = $gift['id_gift'];
            $stock_quantity = $gift['stock_quantity']--;
            // Add gifts to user
            $this->db->query("INSERT INTO gift_choice (id_user, id_gift) VALUES ($userId, $id_gift)");
            // Decrease the amount of gift 
            $this->db->query("UPDATE gift_gift SET stock_quantity = $stock_quantity WHERE id_gift = $id_gift");
        }
        // Retrieve money from the user
        $totalmontant = $this->calculateTotalPrice($suggestions);
        $this->db->query("INSERT INTO gift_move (id_user, montant, description, is_accepted) VALUES ($userId, -$totalmontant, 'Payment', 1)");

        return true;
    }

    public function calculateTotalPrice($gifts)
    {
        $totalmontant = 0;

        foreach ($gifts as $gift) {
            $totalmontant += $gift['montant'];
        }

        return number_format($totalmontant, 2);
    }


    /**
     * ---------------------------
     * Check methods operations
     * ---------------------------
     */
    public function canBuyGift($balance)
    {
        $query = "  SELECT
                         MIN(montant) as min_montant
                    FROM
                         gift_gift
                    WHERE
                         stock_quantity > 0
    ";

        $STH = $this->db->query($query);
        $result = $STH->fetch(PDO::FETCH_ASSOC);

        $minMontant = $result['min_montant'] ?? null;

        if (is_null($minMontant) || $balance < $minMontant) {
            return false;
        }

        return true;
    }


}
