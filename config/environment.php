<?php
namespace PharmaFEFO\Config;

class Environment {
    public static function load($path) {
        if (!file_exists($path)) {
            return false;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // N-tjahylou les commentaires
            if (strpos(trim($line), '#') === 0) continue;
            
            // N-qesmou s-ster b '='
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value);
        }
    }
}
?>