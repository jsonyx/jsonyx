<?php
namespace Jsonyx\Facade;

use Jsonyx\JsonyxInterface;
use Jsonyx\Jsonyx as JsonyxService;

class Jsonyx
{

    const NO_PLUGINS = 1;

    public static function Jsonyx(int $flags = 0): JsonyxInterface
    {
        return static::getInstance([], $flags);
    }

    public static function parseJson(string $json, array $context = []): array
    {
        return static::getInstance($context)->parse($json);
    }

    public static function parseFile(string $file, array $context = []): array
    {

        return static::getInstance($context)->parseFile($file);
    }
    
    protected static function getInstance(array $context = [], int $flags = 0): JsonyxInterface
    {
        $jsonyx = new JsonyxService($context);

        if ($flags & self::NO_PLUGINS) {
            return $jsonyx;
        }

        foreach (self::getDefaultPlugins($jsonyx) as $plugin => $priority) {
            $jsonyx->withPlugin(
                new $plugin($jsonyx), $priority
            );
        }

        return $jsonyx;

    }

    protected static function getDefaultPlugins(JsonyxInterface $jsonyx): array
    {
        return  [
            \Jsonyx\Plugin\Directive\Import::class => 100,
            \Jsonyx\Plugin\Value\Context::class => 100,
            \Jsonyx\Plugin\Value\IncludePlugin::class => 100,
        ];

    }

        
}