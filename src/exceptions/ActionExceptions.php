<?php

namespace App\Exceptions;

/**
 * Class representing one candidate's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class ActionExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}