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

    public static function colorize($text, $status) {

        switch($status) {
            case "SUCCESS":
                $out = "[42m"; //Green background
                break;
            case "ERROR":
                $out = "[41m"; //Red background
                break;
            case "WARNING":
                $out = "[43m"; //Yellow background
                break;
            case "NOTE":
                $out = "[44m"; //Blue background
                break;
            default:
                throw new Exception("Invalid status: " . $status);
        }
        return chr(27) . "$out" . "$text" . chr(27) . "[0m";
    }


}