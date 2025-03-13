<?php
/**
* @package Jsonyx
* @author  Viktor Halitsky (concept.galitsky@gmail.com)
* @license MIT
*/
namespace Jsonyx\Plugin\Value;


use Jsonyx\Plugin\AbstractPlugin;

class Context extends AbstractPlugin
{
    const PATTERN = '/\${(.*?)}/';

    /**
     * {@inheritDoc}
     * 
     * Replace ${...} with the value from the context.
     */
    public function __invoke(mixed $value, string $path, &$data, callable $next): mixed
    {
        if (is_string($value)) { 
            $value = preg_replace_callback(
                static::PATTERN,
                function ($matches) use ($path) {
                    return $this->getJsonix()
                        ->getContext()
                            ->get($matches[1]);
                },
                $value
            );
        }

        return $next($value, $path, $data);
    }
}