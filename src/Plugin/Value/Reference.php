<?php
namespace Jsonyx\Plugin\Value;


use Jsonyx\Plugin\AbstractPlugin;

class Reference extends AbstractPlugin
{
    const PATTERN = '/\@{(.*?)}/';

    
    public function __invoke(mixed $value, string $path, &$data, callable $next): mixed
    {
        if (is_string($value)) { 
            $value = preg_replace_callback(
                '/\${(.*?)}/',
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