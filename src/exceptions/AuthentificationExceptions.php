<?php

namespace App\Exceptions;

/**
 * Class representing one authentification's Exception
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class AuthentificationExceptions extends \Exception {
    public function __construct($message){
        parent::__construct("Accès refusé : " . $message);
    }
}