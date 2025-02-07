<?php

namespace App\Exceptions;

/**
 * Class representing one role's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class RoleExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}