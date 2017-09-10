<?php
namespace LightMvc\Core;

final class ClassLoader {

    public static function registerAutoLoad(): void {
        spl_autoload_register(array(__CLASS__, 'Load'));
    }

    public static function Load(string $className): void {

        $ds = DIRECTORY_SEPARATOR;
        $dir = ROOTDIRECTORY;
        $className = str_replace('\\', $ds, $className);

        $file = "{$dir}{$className}.php";

        if (file_exists($file) && is_readable($file)) {
            require_once $file;
        }
    }
}