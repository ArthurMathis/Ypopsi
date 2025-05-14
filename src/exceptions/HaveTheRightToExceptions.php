<?php

namespace App\Exceptions;

/**
 * Class representing one haveTheRightTo's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class HaveTheRightToExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}