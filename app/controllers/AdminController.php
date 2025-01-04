<?php
namespace App\Controllers;

use Flight;

class AdminController {
    protected $moveModel;
    protected $user;
    
    public function __construct() { 
        $this->moveModel = Flight::moveModel();
        $this->user = $_SESSION['user'];
    }

    public function renderDashboard() {
        $deposits = $this->getNonAcceptedDeposits();
        $data = [
            'title' => 'Giftmas Admin Dashboard',
            'page' => 'index',
            'username' => $this->user['name'],
            'deposits' => $deposits
        ];
        Flight::render('admin/template', $data);
    }

    // Ajax after accepting or rejecting a deposit
    public function getNonAcceptedDeposits() {
        $deposits = $this->moveModel->getNonAcceptedDeposits();
        // Format the date and the money to look user friendly
        $deposits = array_map(function($deposit){
            $deposit['date'] = date('d-m-Y h:m:s', strtotime($deposit['date']));
            $deposit['amount'] = number_format($deposit['montant'],2);
            return $deposit;
        }, $deposits);
        return $deposits;        
    }

    // After changes, echo the rest of the deposits
    public function acceptDeposit() {
        $deposit_id = Flight::request()->data->deposit_id;
        $this->moveModel->acceptDeposit($deposit_id);
        $deposits = $this->getNonAcceptedDeposits();
        Flight::json($deposits);
    }

    public function rejectDeposit() {
        $deposit_id = Flight::request()->data->deposit_id;
        $this->moveModel->rejectDeposit($deposit_id);
        $this->getNonAcceptedDeposits();
        $deposits = $this->getNonAcceptedDeposits();
        Flight::json($deposits);
    }
}