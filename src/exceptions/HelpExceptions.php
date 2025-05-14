<?php

namespace App\Exceptions;

/**
 * Class representing one help's 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class HelpExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}