<?php

class Hasher {

    const salt = "367a70202c651b8";

    public static function getHash($dataString) {
        return hash('sha256', $dataString . salt);
    }

}