<?php

namespace App\Exceptions;

/**
 * Class representing one router's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class RouterExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}