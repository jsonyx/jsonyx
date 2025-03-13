<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*/
namespace Jsonyx\Facade;

use Jsonyx\JsonyxInterface;
use Jsonyx\Jsonyx as JsonyxService;

class Jsonyx
{

    const NO_PLUGINS = 1;

    /**
     * Create a new Jsonyx instance.
     *
     * @param  array  $context  The context data
     * @param  int  $flags      The flags
     * 
     * @return \Jsonyx\JsonyxInterface
     */
    public static function Jsonyx(array $context = [], int $flags = 0): JsonyxInterface
    {
        return static::getInstance($context, $flags);
    }

    /**
     * Parse a JSON string or file.
     *
     * @param  string  $json    The JSON string or file
     * @param  array  $context  The context data
     * 
     * @return array
     */
    public function parse(string $json): array
    {
        if (is_file($json)) {
            return static::parseFile($json);
        }

        return static::parseJson($json);
    }

    /**
     * Parse a JSON string.
     *
     * @param  string  $json    The JSON string
     * @param  array  $context  The context data
     * 
     * @return array
     */
    public static function parseJson(string $json, array $context = []): array
    {
        return static::getInstance($context)->parse($json);
    }

    /**
     * Parse a JSON file.
     *
     * @param  string  $file    The JSON file
     * @param  array  $context  The context data
     * 
     * @return array
     */
    public static function parseFile(string $file, array $context = []): array
    {

        return static::getInstance($context)->parseFile($file);
    }
    
    /**
     * Get a new Jsonyx instance.
     *
     * @param  array  $context  The context data
     * @param  int  $flags      The flags
     * 
     * @return \Jsonyx\JsonyxInterface
     */
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

    /**
     * Get the default plugins.
     *
     * @return array
     */
    protected static function getDefaultPlugins(): array
    {
        return  [
            \Jsonyx\Plugin\Directive\Import::class => 1000,
            \Jsonyx\Plugin\Value\Context::class => 100,
            \Jsonyx\Plugin\Value\IncludePlugin::class => 100,
            \Jsonyx\Plugin\Value\Reference::class => 100,

        ];

    }

        
}