<?php

namespace App\Exceptions;

/**
 * Class representing one application's Exception
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class ApplicationExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}