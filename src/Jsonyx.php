<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*
* The Jsonyx class.
* Provides a simple way to parse JSON data with interpolation.
* Pluggable array component is used to resolve references.
*
*/
namespace Jsonyx;


use Jsonyx\Context\Context;
use Jsonyx\Context\ContextInterface;
use Jsonyx\Exception\RuntimeException;

use JsonException;
use PluggArray\PluggArray;
use Pluggarray\PluggArrayInterface;

class Jsonyx implements JsonyxInterface
{
    /**
     * @var string[]    The stack of source files. Used to detect circular references.
     */
    private array $sourceStack = [];

    /**
     * @var ContextInterface    The context. Used to store and retrieve data for interpolation.
     */
    private ?ContextInterface $context = null;

    /**
     * @var PluggArrayInterface    The pluggable array component.
     */
    private ?PluggArrayInterface $pluggarray = null;

    /**
     * Create a new Jsonyx instance.
     *
     * @param  array  $context  The context data
     * 
     * @return void
     */
    public function __construct(array $context = [])
    {
        $this->getContext()->add($context);
    }

    /**
     * {@inheritDoc}
     */
    public static function withContext(array $context): static
    {
        return new static($context);
    }

    /**
     * {@inheritDoc}
     */
    public function withPlugin(callable $plugin, int $priority = 0): static
    {
        $this->getPluggArray()->register($plugin, $priority);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function parse(string $json): array
    {
        try {

            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        } catch (JsonException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $this->getPluggArray()->plug($data);

        $this->getPluggArray()->resolve($data);

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function parseFile(string $file): array
    {
        if (strpos($file, DIRECTORY_SEPARATOR) !== 0) {
            $file = (
                $this->getContext()->pwd() 
                ?  ($this->getContext()->pwd() . DIRECTORY_SEPARATOR)
                : ''
            ) . $file;
        }

        if (in_array($file, $this->sourceStack)) {
            throw new RuntimeException("Circular reference detected: {$file}");
        }

        array_push($this->sourceStack, $file);

        $pwd = $this->getContext()->pwd();
        $this->getContext()->chdir(dirname($file));

        $data = $this->parse(
            /**
             @todo: Reader
             */
            file_get_contents($file)
        );

        $this->getContext()->chdir($pwd);

        array_pop($this->sourceStack);

        return $data;
    }

    /**
     * Get the pluggable array component.
     * 
     * @return PluggArrayInterface
     */
    protected function getPluggArray(): PluggArrayInterface
    {
        return $this->pluggarray ??= new PluggArray();
    }

    /**
     * {@inheritDoc}
     */
    public function getContext(): ContextInterface
    {
        return $this->context ??= new Context();
    }
}