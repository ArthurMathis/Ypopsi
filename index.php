<?php

require_once("vendor/autoload.php");
require_once('define.php'); 

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\LoginController;

test_process();
env_start();
session_start();

$router = new Router();
$router->addRoute('/', HomeController::class, "display");
$router->addRoute('/login/get', LoginController::class, "display");

$router->dispatch();