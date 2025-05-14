<?php

namespace App\Exceptions;

/**
 * Class representing one establishment's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class EstablishmentExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}