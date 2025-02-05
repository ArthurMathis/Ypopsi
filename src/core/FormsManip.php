<?php

namespace App\Core;

use \InvalidArgumentException;
use App\Core\AlertsManipulation;


/**
 * Class manipulating the data submitted by a form
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class FormsManip {
    // * ALERT * //
    /**
     * Public static methoc generating one error notification
     *
     * @param Array $infos The error informations
     * @return Void
     */
    public static function error_alert(array $infos) {
        if(!isset($infos['icon']) || empty($infos['icon']))
            $infos['icon'] = "error";
        if(!isset($infos['button']))
            $infos['button'] =  true;

        AlertsManipulation::alert($infos);
    }


    // * IS FORMAT * //
    public static function isNameFormat(string $str): bool {
        // Todo : vérifier qu'un str est un Nom (pas de caractères spéciaux et pas de nombres)
        return false;
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