<?php

namespace App\Core;

use \Exception;

/**
 * Class manipulating notification
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class alert_manipulation {
    /**
     * Private static method deleting line break in a string
     *
     * @param String $string The string
     * @return String La chaîne The string without line break
     */
    static private function removeNewLines(string $string): String {
        return str_replace(["\r", "\n", "\r\n"], '<br>', $string);
    } 

    /**
     * Public static method creating a notification (Javascript : SweetAlert2.js)
     *
     * @param Array $infos The notiication data array 
     * @return Void
     */
    static public function alert(array $infos) {
        if($infos['msg'] instanceof Exception)
            $infos['msg'] = $infos['msg']->getMessage();
        $infos['msg'] = alert_manipulation::removeNewLines($infos['msg']);

        if(!isset($infos['title']))    
            $infos['title'] =  "Une erreur est survenue...";
        if(isset($infos['confirm']) && empty($infos['icon']))
            $infos['icon'] = 'question';
        if(empty($infos['icon']) || !is_string($infos['icon']))
            $infos['icon'] = 'success';
        if(isset($infos['button']) && (empty($infos['text button']) || !is_string($infos['text button'])))
            $infos['text button'] = "Compris";

        include(COMMON.DS.'header.php');
        include(COMMON.DS.'alert.php');
        include(COMMON.DS.'footer.php');

        exit;
    }
}