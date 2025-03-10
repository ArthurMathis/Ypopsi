<?php

namespace App\Exceptions;

/**
 * Class representing one haveTheRightTo's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class HaveTheRightToExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}