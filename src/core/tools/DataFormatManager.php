<?php

namespace App\Core\Tools;

use \InvalidArgumentException;

/**
 * Class manipulating the data's format and validity
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class DataFormatManager {
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
     * @param string $str The name 
     * @return string The formated string
     */
    public static function nameFormat(string $str): string {
        return ucwords(strtolower(preg_replace('/[^A-Za-z0-9\- ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))));
    }
    /**
     * Public static method formating string in uppercase without special characters
     *
     * @param string $str The string
     * @return string
     */
    static public function majusculeFormat(string $str): string {
        return strtoupper(preg_replace('/[^A-Za-z0-9\- ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str)));
    }

    /**
     * Public static method formating a phone number
     *
     * @param string $number The phone number
     * @throws InvalidArgumentException 
     * @return ?string
     */
    public static function phoneNumberFormat(string $number): ?string {
        switch($number) {
            case DataFormatManager::isValidPhoneNumber($number):
                return $number;
                
            case (bool) preg_match('/^\d{2}\s\d{2}\s\d{2}\s\d{2}\s\d{2}$/', $number):
                return preg_replace('/\s/', '.', $number);
                
            case (bool) preg_match('/^\d{10}$/', $number):
                return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1.$2.$3.$4.$5', $number);
                
            case (bool) preg_match('/^\d{2}\-\d{2}\-\d{2}\-\d{2}\-\d{2}$/', $number):
                return preg_replace('/-/', '.', $number);

            default: throw new InvalidArgumentException("Le numéro de téléphone : $number est invalide.");
        }
    }
}