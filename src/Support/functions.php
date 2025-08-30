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
            $basePath = \dirname(__DIR__, 2);

            $repo = new ConfigRepository($basePath . '/config');
        }

        return $repo->get($key, $default);
    }
}
