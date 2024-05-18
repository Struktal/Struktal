<?php

if(!isset($icon)) {
    Logger::getLogger("TEMPLIFY")->error("Icon not set");
    echo "!!! Icon not set !!!";
} else {
    $file = __APP_DIR__ . "/htdocs/static/img/icons/" . $icon;
    if(!file_exists($file)) {
        Logger::getLogger("TEMPLIFY")->error("Icon file not found: " . $file);
        echo "!!! Icon file not found: " . $file . " !!!";
    } else {
        echo file_get_contents($file);
    }
}
