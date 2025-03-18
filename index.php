<?php

require_once("vendor/autoload.php");
require_once('define.php'); 

use App\Core\Router\Router;
use App\Core\FormsManip;
use App\Core\AlertsManipulation;
use App\Core\Middleware\AuthMiddleware;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ApplicationsController;
use App\Controllers\CandidatesController;
use App\Controllers\PreferencesController;
use App\Core\Middleware\FeatureMiddleware;

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
    $router->addRoute("/login/get", LoginController::class, "display", array(FeatureMiddleware::$CONNEXION));
    $router->addRoute("/login/set", LoginController::class, "login", array(FeatureMiddleware::$CONNEXION));
    $router->addRoute("/logout", LoginController::class, "logout", array(FeatureMiddleware::$CONNEXION));

    // * APPLICATIONS * //              
    $router->addRoute("/applications",  ApplicationsController::class, "display");              

    // * CANDIDATES * //
    //// PROFILE ////
    $router->addRoute("/candidates", CandidatesController::class, "display");
    $router->addRoute("/candidates/input", CandidatesController::class, "inputCandidate", array(FeatureMiddleware::$INSCRIPT_CANDIDATE), AuthMiddleware::$USER);
    $router->addRoute("/candidates/inscript", CandidatesController::class, "inscriptCandidate", array(FeatureMiddleware::$INSCRIPT_CANDIDATE), AuthMiddleware::$USER);
    $router->addRoute("/candidates/{candidate}", CandidatesController::class, "displayCandidate");
    $router->addRoute("/candidates/edit/{candidate}", CandidatesController::class, "editCandidate", array(FeatureMiddleware::$EDIT_CANDIDATE), AuthMiddleware::$USER);
    $router->addRoute("/candidates/update/{candidate}", CandidatesController::class, "updateCandidate", array(FeatureMiddleware::$EDIT_CANDIDATE), AuthMiddleware::$USER);
    $router->addRoute("/candidates/rating/edit/{candidate}", CandidatesController::class, "displayCandidate", array(FeatureMiddleware::$EDIT_RATING), AuthMiddleware::$USER);                          // todo
    $router->addRoute("/candidates/rating/update/{candidate}", CandidatesController::class, "displayCandidate", array(FeatureMiddleware::$EDIT_RATING), AuthMiddleware::$USER);                        // todo

    //// CONTRACTS ////
    $router->addRoute("/candidates/contracts/input/{candidate}", CandidatesController::class, "displayInputMeeting", array(FeatureMiddleware::$INSCRIPT_CONTRACT), AuthMiddleware::$USER);             // todo
    $router->addRoute("/candidates/contracts/inscript/{candidate}", CandidatesController::class, "displayInputMeeting", array(FeatureMiddleware::$INSCRIPT_CONTRACT), AuthMiddleware::$USER);          // todo
    $router->addRoute("/candidates/contracts/sign/{candidate}/{contract}", CandidatesController::class, "signContract", array(FeatureMiddleware::$INSCRIPT_CONTRACT, FeatureMiddleware::$MANAGE_OFFER), AuthMiddleware::$USER);
    $router->addRoute("/candidates/contracts/dismiss/{contract}", CandidatesController::class, "dismissContract", array(FeatureMiddleware::$MANAGE_CONTRACT), AuthMiddleware::$USER);

    //// OFFERS ////
    $router->addRoute("/candidates/offers/input/{candidate}", CandidatesController::class, "inputOffer", array(FeatureMiddleware::$INSCRIPT_OFFER), AuthMiddleware::$USER);
    $router->addRoute("/candidates/offers/input/{candidate}/{application}", CandidatesController::class, "inputOffer", array(FeatureMiddleware::$INSCRIPT_OFFER), AuthMiddleware::$USER);
    $router->addRoute("/candidates/offers/inscript/{candidate}", CandidatesController::class, "inscriptOffer", array(FeatureMiddleware::$INSCRIPT_OFFER), AuthMiddleware::$USER);
    $router->addRoute("/candidates/offers/inscript/{candidate}/{application}", CandidatesController::class, "inscriptOffer", array(FeatureMiddleware::$INSCRIPT_OFFER, FeatureMiddleware::$MANAGE_APPLICATIPON), AuthMiddleware::$USER);
    $router->addRoute("/candidates/offers/reject/{candidate}/{offer}", CandidatesController::class, "rejectOffer", array(FeatureMiddleware::$MANAGE_OFFER), AuthMiddleware::$USER); 

    //// APPLICATIONS ////
    $router->addRoute("/candidates/applications/input", CandidatesController::class, "inputApplication", array(FeatureMiddleware::$INSCRIPT_APPLICATIPON), AuthMiddleware::$USER);
    $router->addRoute("/candidates/applications/input/{candidate}", CandidatesController::class, "inputApplication", array(FeatureMiddleware::$INSCRIPT_APPLICATIPON), AuthMiddleware::$USER);       
    $router->addRoute("/candidates/applications/inscript", CandidatesController::class, "inscriptApplication", array(FeatureMiddleware::$INSCRIPT_APPLICATIPON), AuthMiddleware::$USER);
    $router->addRoute("/candidates/applications/inscript/{candidate}", CandidatesController::class, "inscriptApplication", array(FeatureMiddleware::$INSCRIPT_APPLICATIPON), AuthMiddleware::$USER);
    $router->addRoute("/candidates/applications/reject/{candidate}/{application}", CandidatesController::class, "rejectApplication", array(FeatureMiddleware::$MANAGE_APPLICATIPON), AuthMiddleware::$USER);     

    //// MEETINGS ////
    $router->addRoute("/candidates/meeting/input/{candidate}", CandidatesController::class, "inputMeeting", array(FeatureMiddleware::$INSCRIPT_MEETING), AuthMiddleware::$USER);
    $router->addRoute("/candidates/meeting/inscript/{candidate}", CandidatesController::class, "inscriptMeeting", array(FeatureMiddleware::$INSCRIPT_MEETING), AuthMiddleware::$USER);
    $router->addRoute("/candidates/meeting/edit/{meeting}", CandidatesController::class, "editMeeting", array(FeatureMiddleware::$EDIT_MEETING), AuthMiddleware::$USER);
    $router->addRoute("/candidates/meeting/update/{candidate}/{meeting}", CandidatesController::class, "updateMeeting", array(FeatureMiddleware::$EDIT_MEETING), AuthMiddleware::$USER);
    $router->addRoute("/candidates/meeting/delete/{meeting}", CandidatesController::class, "deleteMeeting", array(FeatureMiddleware::$DELETE_MEETING), AuthMiddleware::$USER);

    // * PREFERENCES * //
    //// PROFILE ////
    $router->addRoute("/preferences/{user}", PreferencesController::class, "display", );
    // todo : add the edit and update users routes
    $router->addRoute("/preferences/logs/{user}", PreferencesController::class, "displayUserLogs");
    $router->addRoute("/preferences/logs/actions/{user}", PreferencesController::class, "displayUserLogsActions");

    //// USERS ////
    $router->addRoute("/preferences/users", PreferencesController::class, "displayUsers", null, AuthMiddleware::$ADMIN);
    $router->addRoute("/preferences/users/new", PreferencesController::class, "displayNewUsers", null, AuthMiddleware::$ADMIN);
    $router->addRoute("/prefrences/logs", PreferencesController::class, "displayLogs", null, AuthMiddleware::$ADMIN);
    $router->addRoute("/prefrences/logs/actions", PreferencesController::class, "displayLogsActions", null, AuthMiddleware::$ADMIN);

    //// RECRUITEMENT ////
    $router->addRoute("/preferences/jobs", PreferencesController::class, "displayJobs");
    $router->addRoute("/preferences/qualifications", PreferencesController::class, "displayQualifications");
    $router->addRoute("preferences/sources", PreferencesController::class, "displaySources");

    //// FOUNDATION ////
    $router->addRoute("/preferences/services", PreferencesController::class, "displayServices");
    $router->addRoute("/preferences/establishments", PreferencesController::class, "displayEstablishments");
    $router->addRoute("/preferences/hubs", PreferencesController::class, "displayhubs");

    $router->dispatch($user_connected);

} catch(Exception $e) {
    FormsManip::error_alert([
        'msg'       => $e,
        'direction' => APP_PATH
    ]);
}
