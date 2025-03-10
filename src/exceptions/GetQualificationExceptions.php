<?php

namespace App\Exceptions;

/**
 * Class representing one GetQualification's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class GetQualificationExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}