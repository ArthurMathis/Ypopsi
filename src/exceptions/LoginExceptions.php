<?php

namespace App\Exceptions;

/**
 * Class representing one login's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class LoginExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}