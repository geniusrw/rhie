<?php
namespace Geniusrw\Rhie\Support;

use Dotenv\Dotenv;

final class Env
{
    private static bool $loaded = false;

    /**
     * Load .env once. By default it assumes your project root is one level
     * above /src. You can override by defining GENIUS_RHIE_BASE_PATH.
     */
    public static function load(?string $basePath = null): void
    {
        if (self::$loaded) {
            return;
        }

        // Allow the app to override base path if needed
        if ($basePath === null) {
            $basePath = \dirname(__DIR__, 2); // project root if src/ is directly under it
        }
        
        if (\is_string($basePath) && \file_exists($basePath.'/.env')) {
            $dotenv = Dotenv::createImmutable($basePath);
            $dotenv->safeLoad(); // no exception if .env missing
        }

        self::$loaded = true;
    }
}
