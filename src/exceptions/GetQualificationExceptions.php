<?php

namespace App\Exceptions;

/**
 * Class representing one GetQualification's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class GetQualificationExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}