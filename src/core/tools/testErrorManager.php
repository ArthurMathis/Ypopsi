<?php

namespace App\Core\Tools;

/**
 * Class writing in the console the error's message
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class testErrorManager {
    /**
     * Public static method returning the message's start
     *
     * @return string
     */
    public static function error(): string { return "Failed asserting that : "; }

    /**
     * Public static method returning the error's message for right/false test
     *
     * @param string $str The value
     * @param boolean $valid The test's state
     * @return string
     */
    public static function cerr(string $str, bool $valid): string {
        $err = $valid ? "invalid" : "valid";
        return testErrorManager::error() . "{$str} is {$err}.";
    }

    /**
     * Public static method returning the error's message for euals tests
     *
     * @param ?string $str1 The first value
     * @param ?string $str2 The second
     * @return string
     */
    public static function cerr_eq(?string $str1 = null, ?string $str2 = null): string {
        $str1 = $str1 ? $str1 : "'vide'";
        $str2 = $str2 ? $str2 : "'vide'";
        return testErrorManager::error() . "{$str1} is equals to {$str2}.";
    }

    /**
     * Public static method returning the error's message for null tests
     *
     * @param string $str The value
     * @return string
     */
    public static function cerr_null(?string $str): string {
        return testErrorManager::error() . "{$str} should be null.";
    }
}