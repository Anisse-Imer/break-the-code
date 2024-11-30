<?php

class utils {
    // "2;3;2;4" --> [2,3,2,4]
    public static function stringToArray($str) {
        $array = explode(';', $str);
        $array = array_map('intval', $array);
        return $array;
    }


    //  [2,3,2,4] --> "2;3;2;4"
    public static function arrayToString($array) {
        $array = array_map('strval', $array);
        $str = implode(';', $array);
        return $str;
    }


}