<?php

namespace App\Exceptions;

/**
 * Class representing one TimeManager's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class TimeManagerExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}