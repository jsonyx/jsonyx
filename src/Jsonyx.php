<?php
namespace Jsonyx;

use JsonException;
use Jsonyx\Context\Context;
use Jsonyx\Context\ContextInterface;
use Jsonyx\Exception\RuntimeException;

class Jsonyx implements JsonyxInterface
{
    private array $sourceStack = [];

    private ?ContextInterface $context = null;
    private ?PluginManagerInterface $pluginManager = null;

    public function __construct(array $context = [])
    {
        $this->getContext()->add($context);
    }

    public static function withContext(array $context): static
    {
        return new static($context);
    }

    public function withPlugin(callable $plugin, int $priority = 0): static
    {
        $this->getPluginManager()->register($plugin, $priority);

        return $this;
    }

    public function parse(string $json): array
    {
        try {

            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        } catch (JsonException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $this->getPluginManager()->plug($data);

        $this->getPluginManager()->resolve($data);

        return $data;
    }

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

    public function getPluginManager(): PluginManagerInterface
    {
        return $this->pluginManager ??= new PluginManager();
    }

    public function getContext(): ContextInterface
    {
        return $this->context ??= new Context();
    }

    
}