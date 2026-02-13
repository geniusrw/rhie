<?php
namespace Geniusrw\Rhie\Support;

if (!\function_exists(__NAMESPACE__ . '\\env')) {
    /**
     * Get an environment variable with a default.
     */
    function env(string $key, $default = null) {
        // Ensure .env is loaded before reads
        Env::load();
        
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? \getenv($key);
        return ($value === false || $value === null) ? $default : $value;
    }
}

if (!\function_exists(__NAMESPACE__ . '\\config')) {
    /**
     * Dot-notation config reader, e.g. config('database.host')
     */
    function config(string $key, $default = null) {
        // var_dump($key);
        static $repo = null;

        if ($repo === null) {
            // Ensure .env is loaded first (so config files can call env())
            Env::load();

            // Resolve project root and config path
            $basePath = \defined('GENIUS_RHIE_BASE_PATH')
            ? GENIUS_RHIE_BASE_PATH
            : \dirname(__DIR__, 2);

            $repo = new ConfigRepository($basePath . '/config');
        }

        return $repo->get($key, $default);
    }
}

if(!\function_exists(__NAMESPACE__ . '\\parseFlexibleDate')) {
    function parseFlexibleDate($dateInput) {
        if (empty($dateInput)) {
            return null;
        }
        
        // If it's already a DateTime object, just format it
        if ($dateInput instanceof DateTime) {
            return $dateInput->format("Y-m-d");
        }
        
        // Common date formats to try
        $formats = [
            'Y-m-d',           // 2024-02-13
            'd/m/Y',           // 13/02/2024
            'm/d/Y',           // 02/13/2024
            'd-m-Y',           // 13-02-2024
            'm-d-Y',           // 02-13-2024
            'Y/m/d',           // 2024/02/13
            'd.m.Y',           // 13.02.2024
            'Y.m.d',           // 2024.02.13
            'd M Y',           // 13 Feb 2024
            'd F Y',           // 13 February 2024
            'M d, Y',          // Feb 13, 2024
            'F d, Y',          // February 13, 2024
            'd-M-Y',           // 13-Feb-2024
            'Y-m-d H:i:s',     // 2024-02-13 14:30:00
            'd/m/Y H:i:s',     // 13/02/2024 14:30:00
        ];
        
        // Try each format
        foreach ($formats as $format) {
            $date = DateTime::createFromFormat($format, $dateInput);
            if ($date !== false && $date->format($format) === $dateInput) {
                return $date->format("Y-m-d");
            }
        }
        
        // If none of the specific formats work, try strtotime as fallback
        $timestamp = strtotime($dateInput);
        if ($timestamp !== false) {
            return date("Y-m-d", $timestamp);
        }
        
        // If all else fails, return null or throw exception
        return null;
    }

// Usage
// $formattedDate = ;
}
