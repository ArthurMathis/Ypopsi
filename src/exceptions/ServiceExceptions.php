<?php

namespace App\Exceptions;

/**
 * Class representing one service's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class ServiceExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}