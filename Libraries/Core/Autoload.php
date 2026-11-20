<?php

spl_autoload_register(function ($className) {
    $path = "Libraries/Core/{$className}.php";

    if (file_exists($path)) {
        require_once $path;
    }
});
