<?php

class Splitter {

    public static function splitGDSProperties($propsString) {
        $propsString = trim($propsString);
        $lines = explode("\n", $propsString);
        foreach ($lines as $line) {
            $pos = strrpos($line, ":");
            $item['key'] = trim(substr($line, 0, $pos));
            $item['value'] = trim(substr($line, $pos + 1));

            if (0 != strcmp("", $item['key']) && 0 != strcmp("", $item['value']))
                $result[] = $item;
        }

        return $result;
    }

    public static function desplitGDSProperties($imgGdsProps) {
        if (count($imgGdsProps))
            foreach ($imgGdsProps as $imgGdsProp) {
                $result .= $imgGdsProp['name'] . ": " . $imgGdsProp['value'] . "\n";
            }

        return trim($result);
    }

}