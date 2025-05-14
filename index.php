<?php

require_once("vendor/autoload.php");
require_once('define.php'); 

use App\Core\Router\Router;
use App\Core\Tools\AlertsManip;
use App\Core\Middleware\AuthMiddleware;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ApplicationsController;
use App\Controllers\CandidatesController;
use App\Controllers\PreferencesController;
use App\Core\Middleware\FeatureMiddleware;
use App\Exceptions\FeatureExceptions;

$user_connected = !(!isset($_SESSION['user']) || empty($_SESSION['user']) || empty($_SESSION['user']->getId())); 

try {
    $router = new Router();
    $router->addRoute("/", HomeController::class, "display");

    // * LOGIN * //
    $router->addRoute("/login/get", LoginController::class, "display", [FeatureMiddleware::$CONNEXION]);
    $router->addRoute("/login/set", LoginController::class, "login", [FeatureMiddleware::$CONNEXION]);
    $router->addRoute("/logout", LoginController::class, "logout", [FeatureMiddleware::$CONNEXION]);

    // * APPLICATIONS * //              
    $router->addRoute("/applications", ApplicationsController::class, "display", [FeatureMiddleware::$DISPLAY_APPLICATIONS]);              

    // * CANDIDATES * //
    //// PROFILE ////
    $router->addRoute("/candidates", CandidatesController::class, "display", [FeatureMiddleware::$DISPLAY_CANDIDATES]);
    $router->addRoute("/candidates/input", CandidatesController::class, "inputCandidate", [FeatureMiddleware::$INSCRIPT_CANDIDATE], AuthMiddleware::$USER);
    $router->addRoute("/candidates/inscript", CandidatesController::class, "inscriptCandidate", [FeatureMiddleware::$INSCRIPT_CANDIDATE], AuthMiddleware::$USER);
    $router->addRoute("/candidates/{candidate}", CandidatesController::class, "displayCandidate", [FeatureMiddleware::$DISPLAY_CANDIDATE]);
    $router->addRoute("/candidates/edit/{candidate}", CandidatesController::class, "editCandidate", [FeatureMiddleware::$EDIT_CANDIDATE], AuthMiddleware::$USER);
    $router->addRoute("/candidates/update/{candidate}", CandidatesController::class, "updateCandidate", [FeatureMiddleware::$EDIT_CANDIDATE], AuthMiddleware::$USER);
    $router->addRoute("/candidates/rating/edit/{candidate}", CandidatesController::class, "editRating", [FeatureMiddleware::$EDIT_RATING], AuthMiddleware::$USER);
    $router->addRoute("/candidates/rating/update/{candidate}", CandidatesController::class, "updateRating", [FeatureMiddleware::$EDIT_RATING], AuthMiddleware::$USER); 

    //// CONTRACTS ////
    $router->addRoute("/candidates/contracts/input/{candidate}", CandidatesController::class, "inputContract", [FeatureMiddleware::$INSCRIPT_CONTRACT], AuthMiddleware::$USER);
    $router->addRoute("/candidates/contracts/inscript/{candidate}", CandidatesController::class, "inscriptContract", [FeatureMiddleware::$INSCRIPT_CONTRACT], AuthMiddleware::$USER);
    $router->addRoute("/candidates/contracts/sign/{candidate}/{contract}", CandidatesController::class, "signContract", [FeatureMiddleware::$INSCRIPT_CONTRACT, FeatureMiddleware::$MANAGE_OFFER], AuthMiddleware::$USER);
    $router->addRoute("/candidates/contracts/dismiss/{contract}", CandidatesController::class, "dismissContract", [FeatureMiddleware::$MANAGE_CONTRACT], AuthMiddleware::$USER);

    //// OFFERS ////
    $router->addRoute("/candidates/offers/input/{candidate}", CandidatesController::class, "inputOffer", [FeatureMiddleware::$INSCRIPT_OFFER], AuthMiddleware::$USER);
    $router->addRoute("/candidates/offers/input/{candidate}/{application}", CandidatesController::class, "inputOffer", [FeatureMiddleware::$INSCRIPT_OFFER], AuthMiddleware::$USER);
    $router->addRoute("/candidates/offers/inscript/{candidate}", CandidatesController::class, "inscriptOffer", [FeatureMiddleware::$INSCRIPT_OFFER], AuthMiddleware::$USER);
    $router->addRoute("/candidates/offers/inscript/{candidate}/{application}", CandidatesController::class, "inscriptOffer", [FeatureMiddleware::$INSCRIPT_OFFER, FeatureMiddleware::$MANAGE_APPLICATIPON], AuthMiddleware::$USER);
    $router->addRoute("/candidates/offers/reject/{candidate}/{offer}", CandidatesController::class, "rejectOffer", [FeatureMiddleware::$MANAGE_OFFER], AuthMiddleware::$USER); 

    //// APPLICATIONS ////
    $router->addRoute("/candidates/applications/input", CandidatesController::class, "inputApplication", [FeatureMiddleware::$INSCRIPT_APPLICATIPON], AuthMiddleware::$USER);
    $router->addRoute("/can!didates/applications/input/{candidate}", CandidatesController::class, "inputApplication", [FeatureMiddleware::$INSCRIPT_APPLICATIPON], AuthMiddleware::$USER);       
    $router->addRoute("/candidates/applications/inscript", CandidatesController::class, "inscriptApplication", [FeatureMiddleware::$INSCRIPT_APPLICATIPON], AuthMiddleware::$USER);
    $router->addRoute("/candidates/applications/inscript/{candidate}", CandidatesController::class, "inscriptApplication", [FeatureMiddleware::$INSCRIPT_APPLICATIPON], AuthMiddleware::$USER);
    $router->addRoute("/candidates/applications/reject/{candidate}/{application}", CandidatesController::class, "rejectApplication", [FeatureMiddleware::$MANAGE_APPLICATIPON], AuthMiddleware::$USER);     

    //// MEETINGS ////
    $router->addRoute("/candidates/meeting/input/{candidate}", CandidatesController::class, "inputMeeting", [FeatureMiddleware::$INSCRIPT_MEETING], AuthMiddleware::$USER);
    $router->addRoute("/candidates/meeting/inscript/{candidate}", CandidatesController::class, "inscriptMeeting", [FeatureMiddleware::$INSCRIPT_MEETING], AuthMiddleware::$USER);
    $router->addRoute("/candidates/meeting/edit/{meeting}", CandidatesController::class, "editMeeting", [FeatureMiddleware::$EDIT_MEETING], AuthMiddleware::$USER);
    $router->addRoute("/candidates/meeting/update/{candidate}/{meeting}", CandidatesController::class, "updateMeeting", [FeatureMiddleware::$EDIT_MEETING], AuthMiddleware::$USER);
    $router->addRoute("/candidates/meeting/delete/{meeting}", CandidatesController::class, "deleteMeeting", [FeatureMiddleware::$DELETE_MEETING], AuthMiddleware::$USER);

    // * PREFERENCES * //
    //// USERS ////
    $router->addRoute("/preferences", PreferencesController::class, "display"); 
    $router->addRoute("/preferences/users", PreferencesController::class, "displayUser", [FeatureMiddleware::$DISPLAY_USERS], AuthMiddleware::$ADMIN);                                                              // todo
    $router->addRoute("/preferences/users/new", PreferencesController::class, "displayNewUser", [FeatureMiddleware::$DISPLAY_USERS], AuthMiddleware::$ADMIN);                                                       // todo
    $router->addRoute("/preferences/users/input", PreferencesController::class, "inputUser", [FeatureMiddleware::$INSCRIPT_USER], AuthMiddleware::$ADMIN);                                                          // todo
    $router->addRoute("/preferences/users/inscript", PreferencesController::class, "inscriptUser", [FeatureMiddleware::$INSCRIPT_USER], AuthMiddleware::$ADMIN);                                                    // todo
    $router->addRoute("/preferences/users/edit/{user}", PreferencesController::class, "editUser", [FeatureMiddleware::$EDIT_USER], AuthMiddleware::$ADMIN);                                                         // todo
    $router->addRoute("/preferences/users/update/{user}", PreferencesController::class, "updateUser", [FeatureMiddleware::$EDIT_USER], AuthMiddleware::$ADMIN);                                                     // todo
    $router->addRoute("/preferences/users/fetch_reset_password/{user}", PreferencesController::class, "fetchResetPassword", [FeatureMiddleware::$RESET_PASSWORD], AuthMiddleware::$ADMIN);
    $router->addRoute("/preferences/users/reset_password/{user}", PreferencesController::class, "resetPassword", [FeatureMiddleware::$RESET_PASSWORD], AuthMiddleware::$ADMIN);
    // $router->addRoute("/preferences/users/activate/{user}", PreferencesController::class, "activateUser", [FeatureMiddleware::$ACTIVATE_USER], AuthMiddleware::$ADMIN);                                           // todo
    // $router->addRoute("/preferences/users/desactivate/{user}", PreferencesController::class, "desactivateUser", [FeatureMiddleware::$DESACTIVATE_USER], AuthMiddleware::$ADMIN);                                  // todo

    //// PROFILE ////
    $router->addRoute("/preferences/users/profile/{user}", PreferencesController::class, "displayProfile", [FeatureMiddleware::$DISPLAY_USER]);
    $router->addRoute("/preferences/users/profile/edit/{user}", PreferencesController::class, "editUser", [FeatureMiddleware::$EDIT_USER], AuthMiddleware::$USER);
    $router->addRoute("/preferences/users/profile/update/{user}", PreferencesController::class, "updateUser", [FeatureMiddleware::$EDIT_USER], AuthMiddleware::$USER);
    $router->addRoute("/preferences/users/profile/password/edit/{user}", PreferencesController::class, "editPassword", [FeatureMiddleware::$EDIT_PASSWORD]);
    $router->addRoute("/preferences/users/profile/password/update/{user}", PreferencesController::class, "updatePassword", [FeatureMiddleware::$EDIT_PASSWORD]);
    
    //// LOGS ////
    $router->addRoute("/prefrences/logs", PreferencesController::class, "displayLogs", [FeatureMiddleware::$DISPLAY_CONNEXIONS], AuthMiddleware::$ADMIN);
    $router->addRoute("/preferences/logs/actions", PreferencesController::class, "displaysLogAction", [FeatureMiddleware::$DISPLAY_ACTIONS], AuthMiddleware::$ADMIN);                                                 // todo
    $router->addRoute("/preferences/logs/{user}", PreferencesController::class, "displayUserLogs", [FeatureMiddleware::$DISPLAY_CONNEXIONS]);
    $router->addRoute("/preferences/logs/actions/{user}", PreferencesController::class, "displaysUserLogAction", [FeatureMiddleware::$DISPLAY_ACTIONS]);                                                             // todo

    //// JOBS ////
    $router->addRoute("/preferences/jobs", PreferencesController::class, "displayJobs", [FeatureMiddleware::$DISPLAY_JOBS], AuthMiddleware::$USER);                                                                 // todo
    $router->addRoute("/preferences/jobs/input", PreferencesController::class, "inputJob", [FeatureMiddleware::$INSCRIPT_JOBS], AuthMiddleware::$MODERATOR);                                                        // todo
    $router->addRoute("/preferences/jobs/inscript", PreferencesController::class, "inscriptJob", [FeatureMiddleware::$INSCRIPT_JOBS], AuthMiddleware::$MODERATOR);                                                  // todo
    $router->addRoute("/preferences/jobs/edit/{job}", PreferencesController::class, "editJob", [FeatureMiddleware::$EDIT_JOBS], AuthMiddleware::$MODERATOR);                                                        // todo
    $router->addRoute("/preferences/jobs/update/{job}", PreferencesController::class, "updateJob", [FeatureMiddleware::$EDIT_JOBS], AuthMiddleware::$MODERATOR);                                                    // todo

    //// QUALIFICATIONS ////
    $router->addRoute("/preferences/qualifications", PreferencesController::class, "displayQualifications", [FeatureMiddleware::$DISPLAY_QUALIFICATIONS], AuthMiddleware::$USER);                                   // todo
    $router->addRoute("/preferences/qualifications/input", PreferencesController::class, "inputQualification", [FeatureMiddleware::$INSCRIPT_QUALIFICATIONS], AuthMiddleware::$MODERATOR);                          // todo
    $router->addRoute("/preferences/qualifications/inscript", PreferencesController::class, "inscriptQualification", [FeatureMiddleware::$INSCRIPT_QUALIFICATIONS], AuthMiddleware::$MODERATOR);                    // todo
    $router->addRoute("/preferences/qualifications/edit/{qualification}", PreferencesController::class, "editQualification", [FeatureMiddleware::$EDIT_QUALIFICATIONS], AuthMiddleware::$MODERATOR);                // todo
    $router->addRoute("/preferences/qualifications/update/{qualification}", PreferencesController::class, "updateQualification", [FeatureMiddleware::$EDIT_QUALIFICATIONS], AuthMiddleware::$MODERATOR);            // todo

    //// SOURCES ////
    $router->addRoute("/preferences/sources", PreferencesController::class, "displaySources", [FeatureMiddleware::$DISPLAY_SOURCES], AuthMiddleware::$USER);                                                        // todo
    $router->addRoute("/preferences/sources/input", PreferencesController::class, "inputSource", [FeatureMiddleware::$INSCRIPT_SOURCES], AuthMiddleware::$MODERATOR);                                               // todo
    $router->addRoute("/preferences/sources/inscript", PreferencesController::class, "inscriptSource", [FeatureMiddleware::$INSCRIPT_SOURCES], AuthMiddleware::$MODERATOR);                                         // todo
    $router->addRoute("/preferences/sources/edit/{source}", PreferencesController::class, "editSource", [FeatureMiddleware::$EDIT_SOURCES], AuthMiddleware::$MODERATOR);                                            // todo
    $router->addRoute("/preferences/sources/update/{source}", PreferencesController::class, "updateSource", [FeatureMiddleware::$EDIT_SOURCES], AuthMiddleware::$MODERATOR);                                        // todo

    //// SERVICES ////
    $router->addRoute("/preferences/services", PreferencesController::class, "displayServices", [FeatureMiddleware::$DISPLAY_SERVICES], AuthMiddleware::$USER);                                                     // todo
    $router->addRoute("/preferences/services/input", PreferencesController::class, "inputService", [FeatureMiddleware::$INSCRIPT_SERVICES], AuthMiddleware::$MODERATOR);                                            // todo
    $router->addRoute("/preferences/services/inscript", PreferencesController::class, "inscriptService", [FeatureMiddleware::$INSCRIPT_SERVICES], AuthMiddleware::$MODERATOR);                                      // todo
    $router->addRoute("/preferences/services/edit/{service}", PreferencesController::class, "editService", [FeatureMiddleware::$EDIT_SERVICES], AuthMiddleware::$MODERATOR);                                        // todo
    $router->addRoute("/preferences/services/update/{service}", PreferencesController::class, "updateService", [FeatureMiddleware::$EDIT_SERVICES], AuthMiddleware::$MODERATOR);                                    // todo

    //// ESTABLISHMENTS ////
    $router->addRoute("/preferences/establishments", PreferencesController::class, "displayEstablishments", [FeatureMiddleware::$DISPLAY_ESTABLISHMENTS], AuthMiddleware::$USER);                                   // todo
    $router->addRoute("/preferences/esteblishments/input", PreferencesController::class, "inputEstablishment", [FeatureMiddleware::$INSCRIPT_ESTABLISHMENTS], AuthMiddleware::$MODERATOR);                          // todo
    $router->addRoute("/preferences/establishments/inscript", PreferencesController::class, "inscriptEstablishment", [FeatureMiddleware::$INSCRIPT_ESTABLISHMENTS], AuthMiddleware::$MODERATOR);                    // todo
    $router->addRoute("/preferences/establishments/edit/{establishment}", PreferencesController::class, "editEstablishment", [FeatureMiddleware::$EDIT_ESTABLISHMENTS], AuthMiddleware::$MODERATOR);                // todo
    $router->addRoute("/preferences/establishments/update{establishment}", PreferencesController::class, "updateEstablishment", [FeatureMiddleware::$EDIT_ESTABLISHMENTS], AuthMiddleware::$MODERATOR);             // todo

    //// HUBS ////
    $router->addRoute("/preferences/hubs", PreferencesController::class, "displayHubs", [FeatureMiddleware::$DISPLAY_HUBS], AuthMiddleware::$USER);                                                                 // todo
    $router->addRoute("/preferences/hubs/input", PreferencesController::class, "inputHub", [FeatureMiddleware::$INSCRIPT_HUBS], AuthMiddleware::$MODERATOR);                                                        // todo
    $router->addRoute("/preferences/hubs/inscript", PreferencesController::class, "inscriptHub", [FeatureMiddleware::$INSCRIPT_HUBS], AuthMiddleware::$MODERATOR);                                                  // todo
    $router->addRoute("/preferences/hubs/edit/{hub}", PreferencesController::class, "editHub", [FeatureMiddleware::$EDIT_HUBS], AuthMiddleware::$MODERATOR);                                                        // todo
    $router->addRoute("/preferences/hubs/update/{hub}", PreferencesController::class, "updateHub", [FeatureMiddleware::$EDIT_HUBS], AuthMiddleware::$MODERATOR);                                                    // todo

    //// OTHERS ////
    $router->addRoute("/preferences/xlsxLoader", PreferencesController::class, "displayXlsxLoader", null, AuthMiddleware::$OWNER);                                                                                  // todo
    $router->addRoute("/prefrences/xlsxLoader/import", PreferencesController::class, "importFile", null, AuthMiddleware::$OWNER);                                                                                      // todo
    $router->addRoute("/prefrences/xlsxLoader/run", PreferencesController::class, "insertData", null, AuthMiddleware::$OWNER);                                                                                      // todo
    $router->addRoute("/preferences/features_toggles", PreferencesController::class, "displayFeaturesToggles", null, AuthMiddleware::$OWNER);                                                                       // todo
    $router->addRoute("/preferences/features_toggles/update/{feature}", PreferencesController::class, "updateFeature", null, AuthMiddleware::$OWNER);                                                               // todo

    $router->dispatch($user_connected);

} catch(FeatureExceptions $fe) {
    AlertsManip::alert([
        "title"         => "Fonctionnalité indisponible",
        "msg"           => $fe,
        "confirm"       => true,
        "confirmButton" => "Contacter le support",
        "deleteButton"  => "Retour",
        "direction"     => getenv("APP_SUPPORT")
    ]);
} catch(Exception $e) {
    AlertsManip::error_alert([
        "msg"       => $e
    ]);
}
