<?php
namespace App\Controllers;

use Flight;

class MainController
{
    protected $giftModel;
    protected $userModel;
    protected $user;

    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            $error = "You must be logged in to access the dashboard.";
            Flight::render('error', ['message' => "AuthController->__construct(): " . $error]);
        }
        $this->giftModel = Flight::giftModel();
        $this->userModel = Flight::userModel();
        $this->user = $_SESSION['user'];
    }

    /**
     * ---------------------------
     * Page rendering methods
     * ---------------------------
     */
    public function renderMainPage($message = "")
    {
        $data = [
            'title' => 'Dashboard',
            'page' => 'index',
            'balance' => $this->userModel->getActualUserBalance(),
            'username' => $this->user['name'],
            'message' => $message
        ];
        Flight::render('main/template', $data);
    }

    public function renderAccountPage($message = "")
    {
        $userId = $this->user['id_user'];
        $data = [
            'title' => 'Dashboard',
            'page' => 'account',
            'balance' => $this->userModel->getActualUserBalance(),
            'purchasedGifts' => $this->giftModel->getPurchasedGifts($userId),
            'username' => $this->user['name'],
            'message' => $message
        ];
        Flight::render('main/template', $data);
    }

    /**
     * ---------------------------
     * Gift interaction
     * ---------------------------
     */

    public function getGifts()
    {
        $balance = $this->userModel->getActualUserBalance();
        if(!$this->giftModel->canBuyGift($balance)) {
            Flight::json(['error' => true, 'message' => 'You don\'t have enough money'], 400); // xhr error 
            return;
        }
        // query for GET and data for POST 😭
        $data = Flight::request()->query;
        $boys = $data->boys;
        $girls = $data->girls;

        $gifts = $this->giftModel->getGiftSuggestions($boys, $girls);

        $_SESSION['gift_suggestions'] = $gifts; // This will be used everytime from now

        $totalPrice = $this->getTotalPrice();
        Flight::json([
            'gifts' => $gifts,
            'total_price' => $totalPrice
        ]);
    }

    public function replaceGift()
    {
        $data = Flight::request()->query;
        $index = $data->index;
        sleep(1);
        if ($newGift = $this->giftModel->replaceGift($index, $_SESSION['gift_suggestions'])){
            $totalPrice = $this->getTotalPrice();
            Flight::json(['new_gift' => $newGift, 'total_price' => $totalPrice]);
        }
        else
            Flight::json(['error' => true, 'message' => 'No gift index provided'], 400);
    }


    public function validateGifts()
    {
        $userId = $this->user['id_user'];
        $result = $this->giftModel->finalizeSelections($userId, $_SESSION['gift_suggestions']);
        if ($result)
            unset($_SESSION['gift_suggestions']);

        $this->renderMainPage('Gift purchase successfully validated!');
    }
    
    // Total price of the suggestion
    public function getTotalPrice()
    {
        return $this->giftModel->calculateTotalPrice($_SESSION['gift_suggestions']);
    }

    /**
     * ---------------------------
     * Account interaction
     * ---------------------------
     */
    public function getAccountOverview()
    {
        $userId = $this->user['id_user'];
        $purchasedGifts = $this->giftModel->getPurchasedGifts($userId);

        // Fetch the user's deposits
        $deposits = $this->userModel->getUserDeposits($userId);

        return [
            'purchasedGifts' => $purchasedGifts,
            'deposits' => $deposits
        ];
    }


}