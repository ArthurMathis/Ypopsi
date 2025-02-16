<?php

namespace App\Exceptions;

/**
 * Class representing one source's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class SourceExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}