<?php

namespace App\Core\Tools;

/**
 * Class creating random password
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class PasswordsManip {
    // * ATTRIBUTES * //
    /**
     * Public static string with uppercase letters of the alphabet
     *
     * @var string The string
     */
    static public $majuscules = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    /**
     * Public static string with lowercase letters of the alphabet
     *
     * @var string The string
     */
    static public $minuscules = 'abcdefghijklmnopqrstuvwxyz';
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
    static public $specials = '(){}[\]&#_@+!*?:;,.%<>-';

    // * METHODS * //
    /**
     * Public static method checking if the password is valid
     *
     * @param String $password The password to check
     * @return bool True if the password is valid, false otherwise
     */
    public static function isValidPassword(string $password): bool {
        return !(strlen($password) < 12 || 
                !(bool) strpbrk($password, PasswordsManip::$minuscules) || 
                !(bool) strpbrk($password, PasswordsManip::$majuscules) || 
                !(bool) strpbrk($password, PasswordsManip::$chiffres)   || 
                !(bool) strpbrk($password, PasswordsManip::$specials)
            );
    }

    /**
     * Public static method generating a random password
     *
     * @return String The new password
     */
    public static function random_password(): String {
        $password = '';
        $password .= PasswordsManip::$majuscules[rand(0, strlen(PasswordsManip::$majuscules) - 1)];
        $password .= PasswordsManip::$minuscules[rand(0, strlen(PasswordsManip::$minuscules) - 1)];
        $password .= PasswordsManip::$chiffres[rand(0, strlen(PasswordsManip::$chiffres) - 1)];
        $password .= PasswordsManip::$specials[rand(0, strlen(PasswordsManip::$specials) - 1)];

        $all = PasswordsManip::$majuscules . PasswordsManip::$minuscules . PasswordsManip::$chiffres;
        for ($i = 4; $i < 12; $i++) {
            $password .= $all[rand(0, strlen($all) - 1)];
        }
        return str_shuffle($password);
    }
}