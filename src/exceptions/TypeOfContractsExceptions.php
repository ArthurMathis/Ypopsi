<?php

namespace App\Exceptions;

/**
 * Class representing one type of contracts's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class TypeOfContractsExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}