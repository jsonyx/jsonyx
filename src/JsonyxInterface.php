<?php
namespace Jsonyx;

use Concept\Config\Plugin\PluginInterface;
use Jsonyx\Context\ContextInterface;

interface JsonyxInterface
{
    public static function withContext(array $context): static;
    public function withPlugin(callable $plugin, int $priority = 0): static;
    public function parse(string $json): array;
    public function parseFile(string $file): array;
    public function getContext(): ContextInterface;

}