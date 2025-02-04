<?php

require_once("vendor/autoload.php");
require_once('define.php'); 

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Core\FormsManip;

test_process();
env_start();
session_start();

try {
    $router = new Router();
    $router->addRoute('/', HomeController::class, "display");

    $router->addRoute('/login/get', LoginController::class, "display");
    $router->addRoute('/login/set', LoginController::class, "login");
    $router->addRoute('/logout', LoginController::class, "logout");
    
    $router->dispatch();
} catch(Exception $e) {
    FormsManip::error_alert([
        'msg'       => $e,
        'direction' => APP_PATH
    ]);
}
