<?php

namespace App\Exceptions;

/**
 * Class representing one role's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class RoleExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}