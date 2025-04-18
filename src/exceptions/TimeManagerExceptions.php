<?php

namespace App\Exceptions;

/**
 * Class representing one TimeManager's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class TimeManagerExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}