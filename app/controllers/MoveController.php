<?php
namespace App\Controllers;

use Flight;

class MoveController {
    protected $moveModel;
    public function __construct() { 
        $this->moveModel = Flight::moveModel();
    }

    public function addDeposit() {
        $amount = Flight::request()->data->amount;
        $userId = $_SESSION['user']['id_user'];
        if($this->moveModel->addDeposit($userId, $amount))
            echo "Deposit done, waiting to be accepted";
        else 
            echo "Failed to make deposit";
    }
}