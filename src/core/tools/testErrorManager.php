<?php

namespace App\Core\Tools;

/**
 * 
 */
class testErrorManager {
    public static function error(): string { return "Failed asserting that : "; }

    public static function cerr(string $str, bool $valid): string {
        $err = $valid ? "invalid" : "valid";
        return testErrorManager::error() . "{$str} is {$err}.";
    }

    public static function cerr_eq(string $str1, string $str2): string {
        return testErrorManager::error() . "{$str1} is equals to {$str2}.";
    }
}