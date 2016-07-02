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

    // ISO DURATION
    public static function ISO8601ToUnixTime($duration) {

        $durationObject = new \DateInterval($duration);
        $durationUnixTime = $durationObject->s + ($durationObject->i * 60) + ($durationObject->h * 60 * 60);

        return $durationUnixTime;
    }

}