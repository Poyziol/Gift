<?php

use app\controllers\LoginController;
// use app\controllers\Home_controller; // Changed HomeController to MainController
use App\Controllers\MainController;
use App\Controllers\AdminController;
use App\Controllers\MoveController;

use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
**/

//AUTO
$router->get("/", function () {
    Flight::redirect("/login/user");                                                    //Automaticly send to this path at the beginning
});

//LOGIN, btw I made it auth for authentication so that login.php won't be confused with the login/ directory
$router->group('/login', function() use ($router) 
{
	$router->get('/user', [ LoginController::class, 'user' ]);                          //send to the function user of the controller LoginContoller
	$router->post("/check-user", [ LoginController::class , 'login_user']);             //send to the function login_user of the controller LoginContoller

    $router->get("/admin", [ LoginController::class , 'admin']);                        //send to the function admin of the controller LoginContoller
    $router->post("/check-admin", [ LoginController::class , 'login_admin']);           //send to the function login_admin of the controller LoginContoller

    $router->get("/sign-up", [ LoginController::class , 'sign_up']);                    //send to the function sign_up of the controller LoginContoller
    $router->post("/create-user", [ LoginController::class , 'login_sign']);    
    
    $router->get('/logout', [LoginController::class,'logout']);
});

/**
 * Small remark:
 * Landing Page: More focused on a single objective (like capturing leads or promoting a product).
 * Home Page: Serves as the main navigation hub for the entire website
 * idk what to do so I made what's supposed to be the home page the MAIN page, change it if you think there could be a better option
 */

// Anything about what the user does
$router->group('/main', function () use ($router) {
    $router->get('/', [MainController::class,'renderMainPage']);
    $router->get('/account', [MainController::class,'renderAccountPage']);
    $router->post('/validate-gifts', [MainController::class,'validateGifts']);
});

// Admin
$router->group('/admin', function () use ($router) {
    $router->get('/', [AdminController::class,'renderDashboard']);
});

// Ajax calls
$router->group('/api', function () use ($router) {
    // Gifts
    $router->get('/gifts', [MainController::class, 'getGifts']);
    $router->get('/replace-gift', [MainController::class, 'replaceGift']);

    // Deposits
    // User
    $router->post('/add/deposit', [MoveController::class, 'addDeposit']);
    // Admin
    $router->post('/accept/deposit/', [AdminController::class, 'acceptDeposit']);
    $router->post('/reject/deposit/', [AdminController::class, 'rejectDeposit']);
});
