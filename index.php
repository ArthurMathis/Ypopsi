<?php

require_once("vendor/autoload.php");
require_once('define.php'); 

use App\Core\Router\Router;
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

    // * CANDIDATES * //
    //// PROFILE ////
    $router->addRoute("/candidates", CandidatesController::class, "display");
    $router->addRoute("/candidates/input", CandidatesController::class, "inputCandidate");
    $router->addRoute("/candidates/inscript", CandidatesController::class, "inscriptCandidate");
    $router->addRoute("/candidates/{candidate}", CandidatesController::class, "displayCandidate");
    $router->addRoute("/candidates/edit/{candidate}", CandidatesController::class, "editCandidate");                             // todo
    $router->addRoute("/candidates/update/{candidate}", CandidatesController::class, "displayCandidate");                           // todo
    $router->addRoute("/candidates/rating/edit/{candidate}", CandidatesController::class, "displayCandidate");                      // todo
    $router->addRoute("/candidates/rating/update/{candidate}", CandidatesController::class, "displayCandidate");                    // todo

    //// CONTRACTS ////
    $router->addRoute("/candidates/contracts/input/{candidate}", CandidatesController::class, "displayInputMeeting");               // todo
    $router->addRoute("/candidates/contracts/inscript/{candidate}", CandidatesController::class, "displayInputMeeting");            // todo
    $router->addRoute("/candidates/contracts/sign/{candidate}/{offer}", CandidatesController::class, "signContract");
    $router->addRoute("/candidates/contracts/dismiss/{contract}", CandidatesController::class, "dismissContract");

    //// OFFERS ////
    $router->addRoute("/candidates/offers/input/{candidate}", CandidatesController::class, "inputOffer");
    $router->addRoute("/candidates/offers/input/{candidate}/{application}", CandidatesController::class, "inputOffer");
    $router->addRoute("/candidates/offers/inscript/{candidate}", CandidatesController::class, "inscriptOffer");
    $router->addRoute("/candidates/offers/inscript/{candidate}/{application}", CandidatesController::class, "inscriptOffer");
    $router->addRoute("/candidates/offers/reject/{candidate}/{offer}", CandidatesController::class, "rejectOffer"); 

    //// APPLICATIONS ////
    $router->addRoute("/candidates/applications/input", CandidatesController::class, "inputApplication");                           // todo
    $router->addRoute("/candidates/applications/input/{candidate}", CandidatesController::class, "inputApplication");       
    $router->addRoute("/candidates/applications/inscript", CandidatesController::class, "inscriptApplication");
    $router->addRoute("/candidates/applications/inscript/{candidate}", CandidatesController::class, "inscriptApplication");
    $router->addRoute("/candidates/applications/reject/{candidate}/{application}", CandidatesController::class, "rejectApplication");     

    //// MEETINGS ////
    $router->addRoute("/candidates/meeting/input/{candidate}", CandidatesController::class, "inputMeeting");
    $router->addRoute("/candidates/meeting/inscript/{candidate}", CandidatesController::class, "inscriptMeeting");
    $router->addRoute("/candidates/meeting/edit/{meeting}", CandidatesController::class, "editMeeting");
    $router->addRoute("/candidates/meeting/update/{candidate}/{meeting}", CandidatesController::class, "updateMeeting");
    $router->addRoute("/candidates/meeting/delete/{meeting}", CandidatesController::class, "deleteMeeting");

    $router->dispatch($user_connected);

} catch(Exception $e) {
    FormsManip::error_alert([
        'msg'       => $e,
        'direction' => APP_PATH
    ]);
}
