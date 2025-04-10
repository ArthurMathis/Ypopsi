<?php

namespace App\Core\Tools;

/**
 * Class creating random password
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class PasswordsManip {
    // * ATTRIBUTES * //
    /**
     * Public static string with uppercase letters of the alphabet
     *
     * @var string The string
     */
    static public $majuscule = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    /**
     * Public static string with lowercase letters of the alphabet
     *
     * @var string The string
     */
    static public $minuscule = 'abcdefghijklmnopqrstuvwxyz';
    /**
     * Public static string with numbers
     *
     * @var string The string
     */
    static public $chiffres = '0123456789';
    /**
     * Public static string with special characters
     *
     * @var string The string
     */
    static public $special = '(){}[\]&#_@+!*?:;,.<>-';

    // * METHODS * //
    /**
     * Public static method checking if the password is valid
     *
     * @param String $password The password to check
     * @return bool True if the password is valid, false otherwise
     */
    public static function isValidPassword(string $password): bool {
        return !(strlen($password) < 12 || 
                !preg_match('/[a-z]/', $password) || 
                !preg_match('/[A-Z]/', $password) || 
                !preg_match('/\d/', $password) || 
                !preg_match('/[(){}[\]&#_@+!*?:;,.<>-]/', $password));
    }

    /**
     * Public static method generating a random password
     *
     * @return String The new password
     */
    public static function random_password(): String {
        $password = '';
        $password .= PasswordsManip::$majuscule[rand(0, strlen(PasswordsManip::$majuscule) - 1)];
        $password .= PasswordsManip::$minuscule[rand(0, strlen(PasswordsManip::$minuscule) - 1)];
        $password .= PasswordsManip::$chiffres[rand(0, strlen(PasswordsManip::$chiffres) - 1)];
        $password .= PasswordsManip::$special[rand(0, strlen(PasswordsManip::$special) - 1)];

        $all = PasswordsManip::$majuscule . PasswordsManip::$minuscule . PasswordsManip::$chiffres;
        for ($i = 4; $i < 12; $i++) {
            $password .= $all[rand(0, strlen($all) - 1)];
        }
        return str_shuffle($password);
    }
}