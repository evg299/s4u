<?php

/**
 *
 */
class FilesWork {

    public static function requestedURL() {
        return "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public static function requestedURL_noParam() {
        return "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];
    }

    public static function appDataDir() {
        return dirname(__FILE__) . "/../../../application_data";
    }

    public static function getExtension($filename) {
        $parts = explode(".", $filename);
        if (1 < count($parts))
            return "." . end($parts);
        else
            return "";
    }

    public static function showImage($image_path, $image_name = "picture") {
        $appDataDir = self::appDataDir();
        $imgPath = $appDataDir . $image_path;
        if (file_exists($imgPath)) {
            $size = getimagesize($imgPath);
            $fp = fopen($imgPath, "rb");
            if ($size && $fp) {
                header("Content-type: {$size['mime']}");
                header("Content-disposition: filename='$image_name'");
                fpassthru($fp);
                exit;
            }
        }
    }

    public static function sendFile($file_path) {
        $appDataDir = self::appDataDir();
        $filePath = $appDataDir . $file_path;
        if (file_exists($filePath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . (filesize($filePath)));
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '";');
            echo file_get_contents($filePath);
        }
    }

}
