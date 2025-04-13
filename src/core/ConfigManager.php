<?php

namespace App\Core;

/**
 * Class initializing the piece software configuration
 * @author Arthur MATHIS - arthur.mathis@diaocnat-mulhouse.fr
 */
class ConfigManager {
    /**
     * Public static method loading an ini file 
     * 
     * @param string $str The file's path 
     * @return void 
     * @author Clément STUTZ - clement.stutz@diaconat-mulhouse.fr
     */
    public static function envLoad(string $str = ".env"): void {
        $env = parse_ini_file($str);
        foreach ($env as $key => $value) {
            putenv("$key=$value");
        }
    }

    /**
     * Public static method setting the error mode
     */
    public static function errorSetting() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}