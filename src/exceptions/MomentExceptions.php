<?php

namespace App\Exceptions;

/**
 * Class representing one moment's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class MomentExceptions extends \Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}