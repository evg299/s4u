<?php

$handler = opendir(dirname(__FILE__));
while ($file = readdir($handler)) {
    if ($file != "." && $file != "..") {
        if (StringHelper::endsWith($file, ".php"))
            require_once dirname(__FILE__) . "/" . $file;
    }
}

