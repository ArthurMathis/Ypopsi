<?php

namespace App\Exceptions;

/**
 * Class representing one qualification's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class QualificationExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}