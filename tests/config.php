<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use App\Core\ConfigManager;

ConfigManager::errorSetting();
ConfigManager::envLoad(__DIR__ . "/../.env");
ConfigManager::envLoad(__DIR__ . "/../.tests.config.env");