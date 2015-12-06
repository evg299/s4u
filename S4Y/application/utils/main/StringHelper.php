<?php

/**
 * Description of StringHelper
 *
 * @author Evgeny
 */
class StringHelper {
    
    public static function massiveSpecialChars(&$arrayObj, $flag){
        foreach ($arrayObj as $key => $value){
            $value = stripcslashes($value);
            $arrayObj[$key] = htmlspecialchars($value, $flag);
        }
    }

    public static function startsWith($haystack, $needle) {
        return !strncmp($haystack, $needle, strlen($needle));
    }

    public static function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

}
