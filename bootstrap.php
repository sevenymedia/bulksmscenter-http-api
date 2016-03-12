<?php

// Load dependencies
require __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

// Load Dotenv\Dotenv if it's available
if (class_exists('Dotenv\Dotenv',true)) {
    try {
        (new Dotenv\Dotenv(__DIR__))->load();
    } catch (Dotenv\Exception\InvalidPathException $exception) {
        //
    }
}
