<?php

namespace Dotenv;

class Dotenv
{
    public static function get_env(string $variable): string
    {
        return getenv($variable);     
    }

    public static function set_env(string $variable, string $value)
    {
        putenv(sprintf('%s=%s', $variable, $value));
    }

    public static function load(string $path)
    {
        $file = $path . '/.env';        
        if (self::get_env('ENV') && is_readable($file . '.' . self::get_env('ENV'))) {
            $file .= '.' . self::get_env('ENV');
        }        
        if (!is_readable($file)) {
            die("File $file does not exist");
        }

        $lines = file($file);
        foreach ($lines as $line) {            
            if (trim($line)) {         
                [$key, $value] = explode('=', $line, 2);
                putenv(sprintf('%s=%s', trim($key), trim($value)));
            }
        }
    }
}