<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*/
namespace Jsonyx\Plugin\Directive;

use DotAccess\DotArray\DotApi as DotArray;
use Jsonyx\Plugin\AbstractPlugin;

class Import extends AbstractPlugin
{
    const PATTERN = '/@import$/i';

    /**
     * {@inheritDoc}
     * 
     * Directives are used to modify the data structure.
     * 
     * Import a JSON file into the data structure into the current "path"(dot notation).
     * Data structure is modified in place.
     * Node is removed from the data structure.
     */
    public function __invoke(mixed $value, string $path, array &$data, callable $next): mixed
    {
        if (is_string($value) && preg_match(static::PATTERN, $path)) {   
            $file = $value;
            $fragment = parse_url($file, PHP_URL_FRAGMENT);
            $path = explode('.', $path);
            array_pop($path);
            $path = implode('.', $path);
            
            if ($fragment) {
                $file = str_replace("#{$fragment}", '', $file);
            }
            $includeData = $this->getJsonix()
                ->parseFile($file);
            
            if ($fragment && is_array($includeData)) {
                $includeData = DotArray::get($includeData, $fragment);
            }

            DotArray::mergeTo($path, $data, $includeData);

            return null;
        }

        return $next($value, $path, $data);
    }
}