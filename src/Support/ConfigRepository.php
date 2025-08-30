<?php
namespace Genius\Rhie\Support;

final class ConfigRepository
{
    private array $items = [];

    public function __construct(string $configPath)
    {
        
        if (\is_dir($configPath)) {
            foreach (\glob($configPath.'/*.php') as $file) {
                $name = \basename($file, '.php');
                $this->items[$name] = require $file;
            }
        }
    }

    public function get(string $key, $default = null)
    {
        // var_dump($key);
        $segments = \explode('.', $key);
        $value = $this->items;
        
        foreach ($segments as $seg) {
            if (\is_array($value) && \array_key_exists($seg, $value)) {
                $value = $value[$seg];
            } else {
                return $default;
            }
        }

        return $value;
    }
}
