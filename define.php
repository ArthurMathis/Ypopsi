<?php 

$app_path = getenv('APP_PATH');
if(empty($app_path)) {
    $app_path = "/ypopsi";
}

define('APP_PATH', $app_path);

////////////////////////////////////////////////////////////////////////////////////////////////////////////
// * ENV * //
function env_start() {
    $env = parse_ini_file('.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}

// * PHP TESTS * //
function test_process() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
// * DIRECTORY * //
define('ROOT', dirname('.'));
define('DS', DIRECTORY_SEPARATOR);

define('LAYOUTS', ROOT.DS.'layouts');
define('ASSETS', LAYOUTS.DS.'assets');
define('PAGES', LAYOUTS.DS.'pages');
define('STYLESHEETS', LAYOUTS.DS.'stylesheet');
define('SCRIPTS', LAYOUTS.DS.'scripts/');

define('FORMS_STYLES', STYLESHEETS.DS.'formulaires');
define('PAGES_STYLES', STYLESHEETS.DS.'pages');

define('IMG', ASSETS.DS.'img');
define('LOGO', IMG.DS.'logo');

define('BARRES', PAGES.DS.'barres');
define('COMMON', PAGES.DS.'common');
define('FORMULAIRES', PAGES.DS.'formulaires');
define('EDIT_FORM', FORMULAIRES.DS.'edit');
define('INSCRIPT_FORM', FORMULAIRES.DS.'inscript');
define('MY_ITEMS', PAGES.DS.'my items');

////////////////////////////////////////////////////////////////////////////////////////////////////////////

// * SECTIONS * //
define('HOME', 1);
define('APPLICATIONS', 2);
define('NEEDS', 3);
define('STATS', 4);
define('PREFERENCES', 5);

// * STATUS OF APPLICATIONS * //
define("ACCEPTED", 'Acceptée');
define("REFUSED", 'Refusée');
define("UNTREATED", 'Non-traitée');
define("COOPTATION", "Prime de cooptation");

////////////////////////////////////////////////////////////////////////////////////////////////////////////
// * ROLES * //
define('OWNER', 1);
define('ADMIN', 2);
define('MOD', 3);
define('USER', 4);
define('INVITE', 5);

//// TESTS ////
define('ERROR', "Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application...");
/**
 * Fonction testing if the user role is superior or equal to ADMIN
 * 
 * @throws Exception If it is not
 * @return bool
 */
function isAdminOrMore() { 
    if($_SESSION['user']->getRole() != OWNER && $_SESSION['user']->getRole() != ADMIN) {
        throw new Exception(ERROR); 
    } 

    return true;
}
/**
 * Fonction testing if the user role is superior or equal to MOD
 * 
 * @throws Exception If it is not
 * @return bool
 */
function isModOrMore() { 
    if($_SESSION['user']->getRole() != OWNER && $_SESSION['user']->getRole() != ADMIN && $_SESSION['user']->getRole() != MOD) {
        throw new Exception(ERROR); 
    }

    return true;
}
/**
 * Fonction testing if the user role is superior or equal to USER
 * 
 * @throws Exception If it is not
 * @return bool
 */
function isUserOrMore() { 
    if($_SESSION['user']->getRole() === INVITE) { 
        throw new Exception(ERROR); 
    }

    return true;
}