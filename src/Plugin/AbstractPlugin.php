<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*/
namespace Jsonyx\Plugin;

use Jsonyx\JsonyxInterface;
use PluggArray\Plugin\PluginInterface;

abstract class AbstractPlugin implements PluginInterface
{
    /**
     * Constructor
     * 
     * @param JsonyxInterface $jsonyx  The Jsonyx instance
     */
    public function __construct(private JsonyxInterface $jsonyx)
    {}

    /**
     * Get the Jsonyx instance
     * 
     * @return JsonyxInterface
     */
    protected function getJsonix(): JsonyxInterface
    {
        return $this->jsonyx;
    }
}