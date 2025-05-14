<?php

namespace App\Exceptions;

/**
 * Class representing one source's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class SourceExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}