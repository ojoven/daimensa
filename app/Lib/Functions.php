<?php

namespace App\Lib;

class Functions {

    // LOGGER
    public static function log($message) {

        // Log to console
        echo $message . PHP_EOL;
    }

    // ARRAYS
    public static function getLeafs($element) {
        $leafs = array();
        foreach ($element as $e) {
            if (is_array($e)) {
                $leafs = array_merge($leafs, self::getLeafs($e));
            } else {
                $leafs[] = $e;
            }
        }
        return $leafs;
    }

}