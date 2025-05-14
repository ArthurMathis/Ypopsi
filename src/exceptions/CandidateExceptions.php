<?php

namespace App\Exceptions;

/**
 * Class representing one candidate's Exception
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class CandidateExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}