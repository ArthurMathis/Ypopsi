<?php

namespace App\Exceptions;

/**
 * Class representing one contract's Exception
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class ContractExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}