<?php
namespace Jsonyx\Plugin;

use Jsonyx\JsonyxInterface;

abstract class AbstractPlugin implements PluginInterface
{
    public function __construct(private JsonyxInterface $jsonyx)
    {}

    protected function getJsonix(): JsonyxInterface
    {
        return $this->jsonyx;
    }
}