<?php

namespace App\Exceptions;

/**
 * Class representing one help's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class HelpExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}