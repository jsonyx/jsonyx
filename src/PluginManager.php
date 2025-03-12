<?php
namespace Jsonyx;

use Jsonyx\Plugin\PluginInterface;

class PluginManager implements PluginManagerInterface
{
    private array $plugins = [];
    private $callStack = null;

    public function __construct()
    {
    }

    public function register(PluginInterface $plugin, int $priority = 0): static
    {
        $this->plugins[$priority][get_class($plugin)] = $plugin;

        $this->callStack = null;

        krsort($this->plugins);

        return $this;
    }

    public function plug(array &$data): static
    {
        $this->plugNode($data, $data, '');

        return $this;
    }

    protected function plugNode(array &$node, array &$dataRef, ?string $path = null): static
    {
        $pluginStack = $this->getCallStack();

        foreach ($node as $key => &$value) {
            $curPath = (null === $path )? "{$path}.{$key}" : $key;

            if (is_array($value)) {
                $this->plug($value, $dataRef, $curPath);
            } else {

                $value = $pluginStack(
                    $value,
                    $curPath,
                    $dataRef
                );
            }
        }

        return $this;
    }

    public function resolve(array &$data, ?string $path = null): static
    {
     
        foreach ($data as $key => &$value) {
            $curPath = $path ? "{$path}.{$key}" : $key;

            if (is_array($value)) {
                $this->resolve($value, $curPath);
            } else {
                while (is_callable($value)) {
                    $value = $value();
                }
                if (null === $value) {
                    unset($data[$key]);
                }
            }
        }

        return $this;
    }

    protected function getCallStack(): callable
    {
        return $this->callStack ??= $this->callStack();
    }

    protected function callStack(): callable
    {
        $plugins = $this->getSortedPlugins();

        return fn (mixed $value, string $path, array &$dataRef) =>
            function () use ($value, $path, &$dataRef, $plugins) {  
                $next = fn($value, $path, &$dataRef) => $value;
                foreach ($plugins as $plugin) {
                    $prev = $next;
                    $next = fn ($value, $path, &$dataRef) => $plugin($value, $path, $dataRef, $prev);
                }
                return $next($value, $path, $dataRef);
            };
    }

    protected function getSortedPlugins(): array
    {
        $sortedPlugins = [];
        foreach ($this->plugins as $priority => $plugins) {
            foreach ($plugins as $plugin) {
                $sortedPlugins[] = $plugin;
            }
        }

        return $sortedPlugins;
    }

}