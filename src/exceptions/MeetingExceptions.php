<?php

namespace App\Exceptions;

/**
 * Class representing one meeting's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class MeetingExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}