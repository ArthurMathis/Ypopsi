<?php

namespace App\Core\Tools;

use \InvalidArgumentException;

/**
 * Class manipulating the data's format and validity
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class DataFormatManip {
    // * IS VALID * //
    /**
     * Public method checking if the given key is valid
     *
     * @param int $key
     * @return boolean
     */
    public static function isValidKey(int $key): bool { return 0 < $key; }

    /**
     * Public method checking if the given string is valid
     * 
     * @param string $str
     * @return boolean
     */
    public static function isValidIdentifier(string &$str): bool {
        $pattern = '/^[a-z]+(\.[a-z]+)$/';
        return (bool) preg_match($pattern, $str);
    }

    /**
     * Public method checking if the given string is valid
     *
     * @param string $str
     * @return boolean
     */
    public static function isValidName(string &$str): bool {
        $pattern = '/^[a-zA-Zà-ÿÀ-Ÿ\s\-]+$/u';
        return (bool) preg_match($pattern, $str);
    }

    /**
     * Public method checking if the given string is valid
     *
     * @param string $str
     * @return boolean
     */
    public static function isValidEmail(string &$str): bool {
        return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Public static method checking if the given string is valid 
     * 
     * @param string $str
     * @return boolean
     */
    public static function isValidPhoneNumber(string &$str): bool {
        $pattern = '/^\d{2}\.\d{2}\.\d{2}\.\d{2}\.\d{2}$/';
        return (bool) preg_match($pattern, $str);
    }

    /**
     * Public static method checking if the given string is valid 
     * 
     * @param string $str
     * @return boolean
     */
    public static function isValidPostCode(string &$str): bool {
        $pattern = '/^\d{5}$/';
        return preg_match($pattern, $str);
    }

    // * FORMAT * //
    /**
     * Public static method formating a name
     *
     * @param String $str The name 
     * @return String The formated string
     */
    public static function nameFormat(string $str): String {
        return ucwords(strtolower(preg_replace('/[^A-Za-z0-9\- ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))));
    }
    /**
     * Public static method formating string in uppercase without special characters
     *
     * @param String $str The string
     * @return String
     */
    static public function majusculeFormat(string $str): String {
        return strtoupper(preg_replace('/[^A-Za-z0-9\- ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str)));
    }

    /**
     * Public static method formating a phone number
     *
     * @param String $number The phone number
     * @return String|Null
     */
    public static function phoneNumberFormat(string $number): ?String {
        $number = preg_replace('/\D/', '', $number);
        if (strlen($number) !== 0 && strlen($number) !== 10) {
            throw new InvalidArgumentException("Le numéro de téléphone incorrect.");   
        } 

        $number = str_pad($number, 10, '0', STR_PAD_LEFT);
        return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1.$2.$3.$4.$5', $number);         
    }
}