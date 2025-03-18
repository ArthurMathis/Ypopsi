<?php

namespace App\Exceptions;

/**
 * Class representing one feature's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class FeatureExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}