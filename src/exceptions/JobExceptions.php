<?php

namespace App\Exceptions;

/**
 * Class representing one job's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class JobExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}