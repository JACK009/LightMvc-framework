<?php
namespace App\LightMvc\Core;

final class ClassLoader {

    public static function registerAutoLoad() {
        spl_autoload_register(array("\App\LightMvc\Core\ClassLoader", 'Load'));
    }

    public static function Load($className) {
        $dir = ROOTDIRECTORY . '/../';
        $ds = DIRECTORY_SEPARATOR;
        $className = str_replace('\\', $ds, $className);

        $file = "{$dir}{$ds}{$className}.php";

        if (file_exists($file) && is_readable($file)) {
            require_once $file;
        }
    }
}