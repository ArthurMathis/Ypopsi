<?php

/**
 * Class creating random password
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class PasswordGenerator {
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
    static public $special = '!@-_?#';


    /**
     * Public static method generating a random password
     *
     * @return string The new password
     */
    public static function random_password(): string {
        $password = '';
        $password .= PasswordGenerator::$majuscule[rand(0, strlen(PasswordGenerator::$majuscule) - 1)];
        $password .= PasswordGenerator::$minuscule[rand(0, strlen(PasswordGenerator::$minuscule) - 1)];
        $password .= PasswordGenerator::$chiffres[rand(0, strlen(PasswordGenerator::$chiffres) - 1)];
        $password .= PasswordGenerator::$special[rand(0, strlen(PasswordGenerator::$special) - 1)];

        $all = PasswordGenerator::$majuscule .PasswordGenerator::$minuscule . PasswordGenerator::$chiffres;
        for ($i = 4; $i < 8; $i++) 
            $password .= $all[rand(0, strlen($all) - 1)];
        return str_shuffle($password);
    }
}