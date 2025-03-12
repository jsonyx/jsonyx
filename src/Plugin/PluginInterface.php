<?php
namespace Jsonyx\Plugin;

interface PluginInterface
{
    public function __invoke(mixed $value, string $path, array &$data, callable $next): mixed;
}