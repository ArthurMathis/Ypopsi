<?php

namespace App\Exceptions;

/**
 * Class representing one user's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class TypeOfActionsExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}