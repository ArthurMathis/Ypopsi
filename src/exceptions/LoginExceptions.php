<?php

namespace App\Exceptions;

/**
 * Class representing one login's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class LoginExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}