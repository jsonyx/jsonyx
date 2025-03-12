<?php
namespace Jsonyx;

use Jsonyx\Plugin\PluginInterface;

interface PluginManagerInterface
{
    public function register(PluginInterface $plugin, int $priority = 0): static;

    public function plug(array &$data): static;

}