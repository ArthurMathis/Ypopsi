<?php 

// On définit les chemins d'accés // 
define('ROOT',dirname('.'));
define('DS',DIRECTORY_SEPARATOR);

define('COMPONENTS', ROOT.DS.'components');
define('MODELS', COMPONENTS.DS.'models');
define('VIEWS', COMPONENTS.DS.'views');
define('CONTROLLERS', COMPONENTS.DS.'controllers');
define('CLASSE', MODELS.DS.'classe');

define('LAYOUTS', ROOT.DS.'layouts');
define('ASSETS', LAYOUTS.DS.'assets');
define('PAGES', LAYOUTS.DS.'pages');

define('BARRES', PAGES.DS.'barres');
define('COMMON', PAGES.DS.'common');
define('FORMULAIRES', PAGES.DS.'formulaires');
define('EDIT_FORM', FORMULAIRES.DS.'edit');
define('INSCRIPT_FORM', FORMULAIRES.DS.'inscript');
define('MY_ITEMS', PAGES.DS.'my items');

define('STYLESHEET', ASSETS.DS.'stylesheet');
define('IMG', ASSETS.DS.'img');
define('LOGO', IMG.DS.'logo');

define('FORMS_STYLES', STYLESHEET.DS.'formulaires');
define('PAGES_STYLES', STYLESHEET.DS.'pages');

define('JAVASCRIPT','layouts/assets/scripts/');

// On définit les rôles //
define('OWNER', 1);
define('ADMIN', 2);
define('MOD', 3);
define('USER', 4);
define('INVITE', 5);

define('HOME', 1);
define('APPLICATIONS', 2);
define('NEEDS', 3);
define('STATS', 4);
define('PREFERENCES', 5);

// On charge le contenu du fichier .env
function env_start() {
    $env = parse_ini_file('.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}

// Autres 
define("ACCEPTED", 'Acceptée');
define("REFUSED", 'Refusée');
define("UNTREATED", 'Non-traitée');
define("COOPTATION", "Prime de cooptation");

// Chemin d'accés vers les img 
define("ETOILE", "layouts/assets/img/etoile.svg");