<?php

spl_autoload_register(function ($class) {
    $file = dirname(dirname(__FILE__)). '/'. $class. '.php';
    $file = str_replace('\\', '/', $file);
    if (file_exists($file)) {
        include_once $file;
    }
}, true);
