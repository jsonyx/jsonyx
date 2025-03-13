<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*
*
* The Context class.
*/
namespace Jsonyx\Context;

use DotArray\DotArray;

class Context implements ContextInterface
{
    /**
     * The data.
     */
    private array $data = [];

    /**
     * The current working directory.
     * Change when chdir() is called.
     * chdir() is called by the Jsonyx::parseFile() method for each file.
     * Means that the current working directory is the file being parsed.
     */
    private string $pwd = '';

    /**
     * Create a new Context instance.
     *
     * @param  array  $data  The data
     * 
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * {@inheritDoc}
     */
    public function reset(): static
    {
        $this->data = [];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $name): mixed
    {
        return DotArray::get($this->data, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function add( array $data): static
    {
        $this->data = DotArray::merge($this->data, $data);

        return $this;
    }


    /**
     * {@inheritDoc}
     */
    public function set(string $name, mixed $value): static
    {
        DotArray::set($this->data, $name, $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function chdir(string $name): static
    {
        $this->pwd = $name;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function pwd(): string
    {
        return $this->pwd;
    }
 
}