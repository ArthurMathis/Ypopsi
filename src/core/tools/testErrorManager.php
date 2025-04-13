<?php

namespace App\Core\Tools;

class testErrorManager {
    public static function cerr(string $str, bool $valid): string {
        $err = $valid ? "invalid" : "valid";
        return "Failed asserting that : {$str} is {$err}.";
    }
}