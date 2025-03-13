<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*/
namespace Jsonyx\Plugin\Value;

use DotArray\DotArray;
use Jsonyx\Plugin\AbstractPlugin;

class IncludePlugin extends AbstractPlugin
{
    /**
     * The pattern to match.
     */
    const PATTERN = '/@include\((.*?)\)/i';

    /**
     * {@inheritDoc}
     * 
     * Include a file
     * Use the syntax: 
     * @include(file.json) 
     * or 
     * @include(file.json#path.to.node)
     * 
     * A fragment can be used to reference a specific node in the included file
     */
    public function __invoke(mixed $value, string $path, array &$data, callable $next): mixed
    {
        if (preg_match(static::PATTERN, $value, $matches)) {

            $file = $matches[1];
            $fragment = parse_url($file, PHP_URL_FRAGMENT);

            if ($fragment) {
                $file = str_replace("#{$fragment}", '', $file);
            }

            $value = $this->getJsonix()
                ->parseFile($file);

            if ($fragment && is_array($value)) {
                $value = DotArray::get($value, $fragment);
            }
        }

        return $next($value, $path, $data);
    }
}