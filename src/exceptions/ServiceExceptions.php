<?php

namespace App\Exceptions;

/**
 * Class representing one service's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class ServiceExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}