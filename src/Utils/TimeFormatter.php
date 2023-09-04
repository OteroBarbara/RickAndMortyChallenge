<?php

namespace App\Utils;

class TimeFormatter
{
    public static function millisecondsToTimeString($milliseconds)
    {
        $seconds = floor($milliseconds / 1000);
        $milliseconds = $milliseconds % 1000;
        return sprintf('%ds %.6fms', $seconds, $milliseconds);
    }
}