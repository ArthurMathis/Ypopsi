<?php

namespace App\Exceptions;

/**
 * Class representing one router's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class RouterExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}