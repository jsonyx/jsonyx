<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
* 
* 
* The context interface.
*/
namespace Jsonyx\Context;

interface ContextInterface
{
    /**
     * Reset the context.
     * 
     * @return static
     */
    public function reset(): static;

    /**
     * Get a value from the context.
     * 
     * @param  string  $path    The name or path of the value.
     *                          May be a dot notation path.
     * 
     * @return mixed
     */
    public function get(string $path): mixed;

    /**
     * Set a value in the context.
     * 
     * 
     * @param  string  $name   The name/path of the value. May be a dot notation path.
     * @param  mixed   $value  The value
     * 
     * @return static
     */
    public function set(string $name, mixed $value): static;

    /**
     * Add data to the context.
     * 
     * @param  array  $data  The data to add
     * 
     * @return static
     */
    public function add(array $data): static;

    /**
     * Change the current directory.
     * 
     * @param  string  $name  The name of the directory
     * 
     * @return static
     */
    public function chdir(string $name): static;

    /**
     * Get the current directory.
     * 
     * @return string
     */
    public function pwd(): string;
}