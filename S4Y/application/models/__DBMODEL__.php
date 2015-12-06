<?php

$dir = dirname(__FILE__);
$handler = opendir($dir);
while ($file = readdir($handler)) {
    if ($file != "." && $file != "..") {
        if (StringHelper::endsWith($file, ".php"))
            require_once dirname(__FILE__) . "/" . $file;
    }
}