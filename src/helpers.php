<?php

if (!function_exists('env')) {
    function env($key,$default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if ($value[0] === '"' && $value[strlen($value)-1] === '"') {
            return substr($value,1,-1);
        }
        return $value;
    }
}

if (!function_exists('str_random')) {
    function str_random($length = 16)
    {
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = openssl_random_pseudo_bytes($size);
            $string .= substr(str_replace(['/','+','='],'',base64_encode($bytes)),0,$size);
        }
        return $string;
    }
}
