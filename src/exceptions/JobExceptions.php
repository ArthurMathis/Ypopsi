<?php

namespace App\Exceptions;

/**
 * Class representing one job's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class JobExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}