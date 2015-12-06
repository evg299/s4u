<?php

class ImageUtil {

    public static function create_small($name_big, $name_small, $max_x, $max_y) {
        list($x, $y, $t, $attr) = getimagesize($name_big);

        if ($t == IMAGETYPE_GIF)
            $big = imagecreatefromgif($name_big);
        else if ($t == IMAGETYPE_JPEG)
            $big = imagecreatefromjpeg($name_big);
        else if ($t == IMAGETYPE_PNG)
            $big = imagecreatefrompng($name_big);
        else
            return;

        if ($x <= $max_x && $y <= $max_y) {
            $xs = $x;
            $ys = $y;
        } else {
            if ($x > $y) {
                $xs = $max_x;
                $ys = $max_x / ($x / $y);
            } else {
                $ys = $max_y;
                $xs = $max_y / ($y / $x);
            }
        }

        $small = imagecreatetruecolor($xs, $ys);
        $res = imagecopyresampled($small, $big, 0, 0, 0, 0, $xs, $ys, $x, $y);
        imagedestroy($big);
        imagejpeg($small, $name_small);
        imagedestroy($small);
    }

}