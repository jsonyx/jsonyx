<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*/
namespace Jsonyx\Plugin\Value;

use Jsonyx\Plugin\AbstractPlugin;
use DotAccess\DotArray\DotApi as DotArray;

class Reference extends AbstractPlugin
{
    /**
     * The pattern to match.
     */
    const PATTERN = '/@reference\((.*?)\)/';

    /**
     * {@inheritDoc}
     * 
     */
    public function __invoke(mixed $value, string $path, array &$data, callable $next): mixed
    {
        if (is_string($value) && preg_match(static::PATTERN, $value, $matches)) {
            $value = DotArray::get($data, $matches[1]);
        }

        return $next($value, $path, $data);
    }
}