<?php

namespace App\Models;

use PDO;

class MoveModel {
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * ---------------------------
     * SELECTING interaction
     * ---------------------------
     */
    public function getAll()
      {
        $query = "  SELECT  
                        m.id_move, m.id_user, m.montant, m.description, m.date, name
                    FROM 
                        gift_move m
                    JOIN 
                        gift_user u 
                    ON 
                        m.id_user = u.id_user";
        $STH = $this->db->prepare($query);
        $STH->execute();
        return $STH->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDeposits() {
        $query = "SELECT  * FROM gift_user_deposits_view";
        $STH = $this->db->prepare($query);
        $STH->execute();
        return $STH->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getNonAcceptedDeposits() {
        $query = "SELECT  * FROM gift_non_accepted_deposits_view";
        $STH = $this->db->prepare($query);
        $STH->execute();
        return $STH->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ---------------------------
     * ADD/REMOVE/UPDATE 
     * ---------------------------
     */
    public function addDeposit($userId, $montant) {
        $query = "INSERT INTO gift_move (id_user, montant, description) VALUES (?, ?, ?)";
        $STH = $this->db->prepare($query);
        if ($STH->execute([$userId, $montant, 'Deposit']))
            return true;
        return false;
    }

    public function acceptDeposit($id_deposit) {
        $query = "UPDATE gift_move SET is_accepted = 1 WHERE id_move = ?";
        $STH = $this->db->prepare($query);
        
        if ($STH->execute([$id_deposit]))
            return true;
        return false;
    }

    public function rejectDeposit($id_deposit) {
      $query = "DELETE FROM gift_move WHERE id_move = ?";
      $STH = $this->db->prepare($query);
      
      if ($STH->execute([$id_deposit]))
          return true;
      return false;
  }
}
