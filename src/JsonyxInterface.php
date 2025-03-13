<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*/
namespace Jsonyx;

use Jsonyx\Context\ContextInterface;

interface JsonyxInterface
{
    /**
     * Create a new Jsonyx instance.
     *
     * @param  array  $context  The context data
     * @param  int  $flags      The flags
     * 
     * @return \Jsonyx\JsonyxInterface
     */
    public static function withContext(array $context): static;

    /**
     * Create a new Jsonyx instance.
     *
     * @param  array  $context  The context data
     * @param  int  $flags      The flags
     * 
     * @return \Jsonyx\JsonyxInterface
     */
    public function withPlugin(callable $plugin, int $priority = 0): static;

    /**
     * Parse a JSON string.
     *
     * @param  string  $json    The JSON string
     * 
     * @return array
     */
    public function parse(string $json): array;

    /**
     * Parse a JSON file.
     *
     * @param  string  $file    The JSON file
     * 
     * @return array
     */
    public function parseFile(string $file): array;

    /**
     * Get the context.
     *
     * @return \Jsonyx\Context\ContextInterface
     */
    public function getContext(): ContextInterface;

}