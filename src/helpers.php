<?php

function env($key,$default = null) {
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
