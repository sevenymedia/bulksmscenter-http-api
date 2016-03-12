<?php

// Load dependencies
require __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

//spl_autoload_register(function ($class) {
//    $prefix = 'BulkSmsCenter\\';
//    $baseDirectory = __DIR__.'/src/BulkSmsCenter/';
//
//    // Check if class uses prefix
//    if (strncmp($prefix,$class,$len = strlen($prefix)) !== 0) {
//        return;
//    }
//
//    $relativeClass = substr($class,$len);
//
//    // replace the namespace prefix with the base directory, replace namespace
//    // separators with directory separators in the relative class name, append
//    // with .php
//    $file = $baseDirectory.str_replace('\\','/',$relativeClass).'.php';
//
//    // if the file exists, require it
//    if (file_exists($file)) {
//        require $file;
//    }
//});


if (class_exists('Dotenv\Dotenv',true)) {
    try {
        (new Dotenv\Dotenv(__DIR__))->load();
    } catch (Dotenv\Exception\InvalidPathException $exception) {
        //
    }
}
