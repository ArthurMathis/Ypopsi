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
use App\Exceptions\FeatureExceptions;

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
    $router->addRoute("/applications", ApplicationsController::class, "display", array(FeatureMiddleware::$DISPLAY_APPLICATIONS));              

    // * CANDIDATES * //
    //// PROFILE ////
    $router->addRoute("/candidates", CandidatesController::class, "display", array(FeatureMiddleware::$DISPLAY_CANDIDATES));
    $router->addRoute("/candidates/input", CandidatesController::class, "inputCandidate", array(FeatureMiddleware::$INSCRIPT_CANDIDATE), AuthMiddleware::$USER);
    $router->addRoute("/candidates/inscript", CandidatesController::class, "inscriptCandidate", array(FeatureMiddleware::$INSCRIPT_CANDIDATE), AuthMiddleware::$USER);
    $router->addRoute("/candidates/{candidate}", CandidatesController::class, "displayCandidate", array(FeatureMiddleware::$DISPLAY_CANDIDATE));
    $router->addRoute("/candidates/edit/{candidate}", CandidatesController::class, "editCandidate", array(FeatureMiddleware::$EDIT_CANDIDATE), AuthMiddleware::$USER);
    $router->addRoute("/candidates/update/{candidate}", CandidatesController::class, "updateCandidate", array(FeatureMiddleware::$EDIT_CANDIDATE), AuthMiddleware::$USER);
    $router->addRoute("/candidates/rating/edit/{candidate}", CandidatesController::class, "editRating", array(FeatureMiddleware::$EDIT_RATING), AuthMiddleware::$USER);
    $router->addRoute("/candidates/rating/update/{candidate}", CandidatesController::class, "updateRating", array(FeatureMiddleware::$EDIT_RATING), AuthMiddleware::$USER); 

    //// CONTRACTS ////
    $router->addRoute("/candidates/contracts/input/{candidate}", CandidatesController::class, "inputContract", array(FeatureMiddleware::$INSCRIPT_CONTRACT), AuthMiddleware::$USER);
    $router->addRoute("/candidates/contracts/inscript/{candidate}", CandidatesController::class, "inscriptContract", array(FeatureMiddleware::$INSCRIPT_CONTRACT), AuthMiddleware::$USER);
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
    //// USERS ////
    $router->addRoute("/preferences", PreferencesController::class, "display");                                                                                                                                 // todo
    $router->addRoute("/preferences/user", PreferencesController::class, "displayUser", array(FeatureMiddleware::$DISPLAY_USERS), AuthMiddleware::$ADMIN);                                                      // todo
    $router->addRoute("/preferences/users/new", PreferencesController::class, "displayNewUser", array(FeatureMiddleware::$DISPLAY_USERS), AuthMiddleware::$ADMIN);                                              // todo
    $router->addRoute("/preferences/user/input", PreferencesController::class, "inputUser", array(FeatureMiddleware::$INSCRIPT_USER), AuthMiddleware::$ADMIN);                                                  // todo
    $router->addRoute("/preferences/user/inscript", PreferencesController::class, "inscriptUser", array(FeatureMiddleware::$INSCRIPT_USER), AuthMiddleware::$ADMIN);                                            // todo
    $router->addRoute("/preferences/user/edit/{user}", PreferencesController::class, "editUser", array(FeatureMiddleware::$EDIT_USER), AuthMiddleware::$ADMIN);                                                 // todo
    $router->addRoute("/preferences/user/update/{user}", PreferencesController::class, "updateUser", array(FeatureMiddleware::$EDIT_USER), AuthMiddleware::$ADMIN);                                             // todo
    $router->addRoute("/preferences/user/reset_password/{user}", PreferencesController::class, "resetPassword", array(FeatureMiddleware::$RESET_PASSWORD), AuthMiddleware::$ADMIN);                             // todo

    //// PROFILE ////
    $router->addRoute("/preferences/user/profile/{user}", PreferencesController::class, "displayProfile", array(FeatureMiddleware::$DISPLAY_USER));                                                             // todo
    $router->addRoute("/preferences/user/profile/edit/{user}", PreferencesController::class, "editUser", array(FeatureMiddleware::$EDIT_USER), AuthMiddleware::$USER);                                          // todo
    $router->addRoute("/preferences/user/profile/update/{user}", PreferencesController::class, "updateUser", array(FeatureMiddleware::$EDIT_USER), AuthMiddleware::$USER);                                      // todo
    $router->addRoute("/preferences/user/profile/password/edit/user", PreferencesController::class, "editPassword", array(FeatureMiddleware::$EDIT_PASSWORD));                                                  // todo
    $router->addRoute("/preferences/user/profile/password/update/user", PreferencesController::class, "editPassword", array(FeatureMiddleware::$EDIT_PASSWORD));                                                // todo
    
    //// LOGS ////
    $router->addRoute("/prefrences/logs", PreferencesController::class, "displayLog", array(FeatureMiddleware::$DISPLAY_CONNEXIONS), AuthMiddleware::$ADMIN);                                                   // todo
    $router->addRoute("/preferences/logs/{user}", PreferencesController::class, "displayUserLog", array(FeatureMiddleware::$DISPLAY_CONNEXIONS));                                                               // todo
    $router->addRoute("/prefrences/logs/actions", PreferencesController::class, "displayLogAction", array(FeatureMiddleware::$DISPLAY_ACTIONS), AuthMiddleware::$ADMIN);                                        // todo
    $router->addRoute("/preferences/logs/actions/{user}", PreferencesController::class, "displayUserLogAction", array(FeatureMiddleware::$DISPLAY_ACTIONS));                                                    // todo

    //// JOBS ////
    $router->addRoute("/preferences/jobs", PreferencesController::class, "displayJobs", array(FeatureMiddleware::$DISPLAY_JOBS), AuthMiddleware::$USER);                                                        // todo
    $router->addRoute("/preferences/jobs/input", PreferencesController::class, "inputJob", array(FeatureMiddleware::$INSCRIPT_JOBS), AuthMiddleware::$MODERATOR);                                               // todo
    $router->addRoute("/preferences/jobs/inscript", PreferencesController::class, "inscriptJob", array(FeatureMiddleware::$INSCRIPT_JOBS), AuthMiddleware::$MODERATOR);                                         // todo
    $router->addRoute("/preferences/jobs/edit/{job}", PreferencesController::class, "editJob", array(FeatureMiddleware::$EDIT_JOBS), AuthMiddleware::$MODERATOR);                                               // todo
    $router->addRoute("/preferences/jobs/update/{job}", PreferencesController::class, "updateJob", array(FeatureMiddleware::$EDIT_JOBS), AuthMiddleware::$MODERATOR);                                           // todo

    //// QUALIFICATIONS ////
    $router->addRoute("/preferences/qualifications", PreferencesController::class, "displayQualifications", array(FeatureMiddleware::$DISPLAY_QUALIFICATIONS), AuthMiddleware::$USER);                          // todo
    $router->addRoute("/preferences/qualifications/input", PreferencesController::class, "inputQualification", array(FeatureMiddleware::$INSCRIPT_QUALIFICATIONS), AuthMiddleware::$MODERATOR);                 // todo
    $router->addRoute("/preferences/qualifications/inscript", PreferencesController::class, "inscriptQualification", array(FeatureMiddleware::$INSCRIPT_QUALIFICATIONS), AuthMiddleware::$MODERATOR);           // todo
    $router->addRoute("/preferences/qualifications/edit/{qualification}", PreferencesController::class, "editQualification", array(FeatureMiddleware::$EDIT_QUALIFICATIONS), AuthMiddleware::$MODERATOR);       // todo
    $router->addRoute("/preferences/qualifications/update/{qualification}", PreferencesController::class, "updateQualification", array(FeatureMiddleware::$EDIT_QUALIFICATIONS), AuthMiddleware::$MODERATOR);   // todo

    //// SOURCES ////
    $router->addRoute("preferences/sources", PreferencesController::class, "displaySources", array(FeatureMiddleware::$DISPLAY_SOURCES), AuthMiddleware::$USER);                                                // todo
    $router->addRoute("preferences/sources/input", PreferencesController::class, "inputSource", array(FeatureMiddleware::$INSCRIPT_SOURCES), AuthMiddleware::$MODERATOR);                                       // todo
    $router->addRoute("preferences/sources/inscript", PreferencesController::class, "inscriptSource", array(FeatureMiddleware::$INSCRIPT_SOURCES), AuthMiddleware::$MODERATOR);                                 // todo
    $router->addRoute("preferences/sources/edit/{source}", PreferencesController::class, "editSource", array(FeatureMiddleware::$EDIT_SOURCES), AuthMiddleware::$MODERATOR);                                    // todo
    $router->addRoute("preferences/sources/update/{source}", PreferencesController::class, "updateSource", array(FeatureMiddleware::$EDIT_SOURCES), AuthMiddleware::$MODERATOR);                                // todo

    //// SERVICES ////
    $router->addRoute("/preferences/services", PreferencesController::class, "displayServices", array(FeatureMiddleware::$DISPLAY_SERVICES), AuthMiddleware::$USER);                                            // todo
    $router->addRoute("/preferences/services/input", PreferencesController::class, "inputService", array(FeatureMiddleware::$INSCRIPT_SERVICES), AuthMiddleware::$MODERATOR);                                   // todo
    $router->addRoute("/preferences/services/inscript", PreferencesController::class, "inscriptService", array(FeatureMiddleware::$INSCRIPT_SERVICES), AuthMiddleware::$MODERATOR);                             // todo
    $router->addRoute("/preferences/services/edit/{service}", PreferencesController::class, "editService", array(FeatureMiddleware::$EDIT_SERVICES), AuthMiddleware::$MODERATOR);                               // todo
    $router->addRoute("/preferences/services/update/{service}", PreferencesController::class, "updateService", array(FeatureMiddleware::$EDIT_SERVICES), AuthMiddleware::$MODERATOR);                           // todo

    //// ESTABLISHMENTS ////
    $router->addRoute("/preferences/establishments", PreferencesController::class, "displayEstablishments", array(FeatureMiddleware::$DISPLAY_ESTABLISHMENTS), AuthMiddleware::$USER);                          // todo
    $router->addRoute("/preferences/esteblishments/input", PreferencesController::class, "inputEstablishment", array(FeatureMiddleware::$INSCRIPT_ESTABLISHMENTS), AuthMiddleware::$MODERATOR);                 // todo
    $router->addRoute("/preferences/establishments/inscript", PreferencesController::class, "inscriptEstablishment", array(FeatureMiddleware::$INSCRIPT_ESTABLISHMENTS), AuthMiddleware::$MODERATOR);           // todo
    $router->addRoute("/preferences/establishments/edit/{establishment}", PreferencesController::class, "editEstablishment", array(FeatureMiddleware::$EDIT_ESTABLISHMENTS), AuthMiddleware::$MODERATOR);       // todo
    $router->addRoute("/preferences/establishments/update{establishment}", PreferencesController::class, "updateEstablishment", array(FeatureMiddleware::$EDIT_ESTABLISHMENTS), AuthMiddleware::$MODERATOR);    // todo

    //// HUBS ////
    $router->addRoute("/preferences/hubs", PreferencesController::class, "displayHubs", array(FeatureMiddleware::$DISPLAY_HUBS), AuthMiddleware::$USER);                                                        // todo
    $router->addRoute("/preferences/hubs/input", PreferencesController::class, "inputHub", array(FeatureMiddleware::$INSCRIPT_HUBS), AuthMiddleware::$MODERATOR);                                               // todo
    $router->addRoute("/preferences/hubs/inscript", PreferencesController::class, "inscriptHub", array(FeatureMiddleware::$INSCRIPT_HUBS), AuthMiddleware::$MODERATOR);                                         // todo
    $router->addRoute("/preferences/hubs/edit/{hub}", PreferencesController::class, "editHub", array(FeatureMiddleware::$EDIT_HUBS), AuthMiddleware::$MODERATOR);                                               // todo
    $router->addRoute("/preferences/hubs/update/{hub}", PreferencesController::class, "updateHub", array(FeatureMiddleware::$EDIT_HUBS), AuthMiddleware::$MODERATOR);                                           // todo

    //// OTHERS ////
    $router->addRoute("/preferences/xlsxLoader", PreferencesController::class, "dispalyXlsxLoader", null, AuthMiddleware::$OWNER);                                                                              // todo
    $router->addRoute("/prefrences/xlsxLoader/run", PreferencesController::class, "insertData", null, AuthMiddleware::$OWNER);                                                                                  // todo
    $router->addRoute("/preferences/features_toggles", PreferencesController::class, "displayFeaturesToggles", null, AuthMiddleware::$OWNER);                                                                   // todo
    $router->addRoute("/preferences/features_toggles/update/{feature}", PreferencesController::class, "updateFeature", null, AuthMiddleware::$OWNER);                                                           // todo

    $router->dispatch($user_connected);

} catch(FeatureExceptions $fe) {
    AlertsManipulation::alert([
        "title"         => "Fonctionnalité indisponible",
        "msg"           => $fe,
        "confirm"       => true,
        "confirmButton" => "Contacter le support",
        "deleteButton"  => "Retour",
        "direction"     => 'mailto:' . getenv("APP_SUPPORT")
    ]);
} catch(Exception $e) {
    FormsManip::error_alert([
        "msg"       => $e,
        "direction" => APP_PATH
    ]);
}
