<?php

namespace App\Exceptions;

/**
 * Class representing one feature's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class FeatureExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}