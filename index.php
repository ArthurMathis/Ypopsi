<?php

require_once("vendor/autoload.php");
require_once('define.php'); 

use App\Core\Router;
use App\Core\FormsManip;
use App\Core\AlertsManipulation;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ApplicationsController;
use App\Controllers\CandidatesController;

test_process();
env_start();
session_start();

$user_connected = !(!isset($_SESSION['user']) || empty($_SESSION['user']) || empty($_SESSION['user']->getId())); 

if($user_connected && $_SESSION['user']->getPasswordTemp()) {
    AlertsManipulation::alert([
        'title' => "Information importante",
        'msg' => "<p>Bienvenue, c'est votre première connexion !</p><p>Vous devez <b>modifier votre mot de passe</b> au plus vite.</p>",
        'icon' => 'warning',
        'direction' => APP_PATH  . "/preferences/user/edit_password", 
        'button' => true
    ]);
}

try {
    $router = new Router();
    
    $router->addRoute("/", HomeController::class, "display");

    // * LOGIN * //
    $router->addRoute("/login/get", LoginController::class, "display");
    $router->addRoute("/login/set", LoginController::class, "login");
    $router->addRoute("/logout", LoginController::class, "logout");

    // * APPLICATIONS * //
    $router->addRoute("/applications",  ApplicationsController::class, "display");
    $router->addRoute("/applications/input/{id}",  ApplicationsController::class, "display");                       // todo
    $router->addRoute("/applications/accept/{id}",  ApplicationsController::class, "display");                      // todo
    $router->addRoute("/applications/reject/{id}",  ApplicationsController::class, "display");                      // todo

    // * CANDIDATES * //
    //// PROFILE ////
    $router->addRoute("/candidates", CandidatesController::class, "display");
    $router->addRoute("/candidates/{id}", CandidatesController::class, "displayCandidate");
    $router->addRoute("/candidates/edit/{id}", CandidatesController::class, "displayCandidate");                    // todo
    $router->addRoute("/candidates/rating/edit/{id}", CandidatesController::class, "displayCandidate");             // todo

    //// MEETINGS ////
    $router->addRoute("/candidates/meeting/input/{id}", CandidatesController::class, "displayInputMeeting");        // todo
    $router->addRoute("/candidates/meeting/edit/{id}", CandidatesController::class, "displayInputMeeting");         // todo
    $router->addRoute("/candidates/meeting/delete/{id}", CandidatesController::class, "displayInputMeeting");       // todo

    //// CONTRACTS ////
    $router->addRoute("/candidates/contracts/input/{id}", CandidatesController::class, "displayInputMeeting");      // todo
    $router->addRoute("/candidates/contracts/dismiss/{id}", CandidatesController::class, "displayInputMeeting");    // todo

    //// OFFERS ////
    $router->addRoute("/candidates/offers/input/{id}", CandidatesController::class, "displayInputMeeting");         // todo
    $router->addRoute("/candidates/offers/accept/{id}", CandidatesController::class, "displayInputMeeting");        // todo
    $router->addRoute("/candidates/offers/reject/{id}", CandidatesController::class, "displayInputMeeting");        // todo

    $router->dispatch($user_connected);
} catch(Exception $e) {
    FormsManip::error_alert([
        'msg'       => $e,
        'direction' => APP_PATH
    ]);
}
