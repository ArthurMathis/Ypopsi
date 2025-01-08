<?php 

// * DIRECTORY * //
define('ROOT',dirname('.'));
define('DS',DIRECTORY_SEPARATOR);

//// PHP BACK-END ////
define('COMPONENTS', ROOT.DS.'components');
define('MODELS', COMPONENTS.DS.'models');
define('VIEWS', COMPONENTS.DS.'views');
define('CONTROLLERS', COMPONENTS.DS.'controllers');
define('CLASSE', MODELS.DS.'classe');

//// PHP FRONT-END ////
define('LAYOUTS', ROOT.DS.'layouts');
define('ASSETS', LAYOUTS.DS.'assets');
define('PAGES', LAYOUTS.DS.'pages');

define('BARRES', PAGES.DS.'barres');
define('COMMON', PAGES.DS.'common');
define('FORMULAIRES', PAGES.DS.'formulaires');
define('EDIT_FORM', FORMULAIRES.DS.'edit');
define('INSCRIPT_FORM', FORMULAIRES.DS.'inscript');
define('MY_ITEMS', PAGES.DS.'my items');

//// ASSETS ////
define('STYLESHEET', ASSETS.DS.'stylesheet');
define('IMG', ASSETS.DS.'img');
define('LOGO', IMG.DS.'logo');
define("ETOILE", "layouts/assets/img/etoile.svg");

define('FORMS_STYLES', STYLESHEET.DS.'formulaires');
define('PAGES_STYLES', STYLESHEET.DS.'pages');

define('JAVASCRIPT','layouts/assets/scripts/');

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
 * @return Void
 */
function isAdminOrMore() { if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN) throw new Exception(ERROR); }
/**
 * Fonction testing if the user role is superior or equal to MOD
 * 
 * @throws Exception If it is not
 * @return Void
 */
function isModOrMore() { if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD) throw new Exception(ERROR); }
/**
 * Fonction testing if the user role is superior or equal to USER
 * 
 * @throws Exception If it is not
 * @return Void
 */
function isUserOrMore() { if($_SESSION['user_role'] === INVITE) throw new Exception(ERROR); }

// * SECTIONS * //
define('HOME', 1);
define('APPLICATIONS', 2);
define('NEEDS', 3);
define('STATS', 4);
define('PREFERENCES', 5);

// * ENV * //
function env_start() {
    $env = parse_ini_file('.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}

// * STATUS OF APPLICATIONS * //
define("ACCEPTED", 'Acceptée');
define("REFUSED", 'Refusée');
define("UNTREATED", 'Non-traitée');
define("COOPTATION", "Prime de cooptation");

// * PHP TESTS * //
function test_process() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}