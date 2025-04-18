<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use App\Core\ConfigManager;

ConfigManager::errorSetting();
ConfigManager::envLoad(__DIR__ . "\.config.env");