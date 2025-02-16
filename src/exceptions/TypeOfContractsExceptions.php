<?php

namespace App\Exceptions;

/**
 * Class representing one type of contracts's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class TypeOfContractsExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}