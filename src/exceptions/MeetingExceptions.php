<?php

namespace App\Exceptions;

/**
 * Class representing one meeting's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class MeetingExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}