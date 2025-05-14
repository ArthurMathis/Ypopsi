<?php

namespace App\Exceptions;

/**
 * Class representing one user's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class UserExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}