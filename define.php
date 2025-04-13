<?php 

use App\Core\ConfigManager;

ConfigManager::errorSetting();
ConfigManager::envLoad();
session_start();

define('APP_PATH', getenv('APP_PATH'));


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