<?php

/**
 * Class manipulating the data submitted by a form
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class forms_manip {
    /**
     * Public static methoc generating one error notification
     *
     * @param array $infos The error informations
     * @return void
     */
    public static function error_alert($infos=[]) {
        if(!isset($infos['icon']) || empty($infos['icon']))
            $infos['icon'] = "error";
        if(!isset($infos['button']))
            $infos['button'] =  true;

        alert_manipulation::alert($infos);
    }
    
    /**
     * Public static method formating a name
     *
     * @param String $str The name 
     * @return String The formated string
     */
    public static function nameFormat($str): String {
        if(!is_string($str))
            throw new Exception("Le formatage d'un nom doit se réaliser sur une chaine de caractères. ");

        return ucwords(strtolower(preg_replace('/[^A-Za-z0-9\- ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))));
    }

    /**
     * Public static method formating a phone number
     *
     * @param string $number The phone number
     * @return string|null
     */
    public static function numberFormat($number): ?string {
        $number = preg_replace('/\D/', '', $number);
    
        if (strlen($number) !== 0 && strlen($number) !== 10)
            throw new InvalidArgumentException("Le numéro de téléphone incorrect.");   
    
        $number = str_pad($number, 10, '0', STR_PAD_LEFT);
        return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1.$2.$3.$4.$5', $number);         
    }
    
    /**
     * Public static method formating string in uppercase without special characters
     *
     * @param string $str The string
     * @return string
     */
    static public function majusculeFormat($str): string {
        if(!is_string($str))
            throw new Exception("Le formatage d'un nom doit se réaliser sur une chaine de caractères. ");

        // Convertit les caractères accentués en caractères non accentués et en majuscule
        return strtoupper(preg_replace('/[^A-Za-z0-9\- ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str)));
    }
}