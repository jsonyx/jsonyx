<?php
namespace Jsonyx\Plugin\Directive;



use Jsonyx\Mix\ArrayPath;
use Jsonyx\Plugin\AbstractPlugin;

class Import extends AbstractPlugin
{
    const PATTERN = '/@import$/i';

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
echo "<h1>$file</h1>";
            $includeData = $this->getJsonix()
                ->parseFile($file);
            
            if ($fragment && is_array($includeData)) {
                $includeData = ArrayPath::get($includeData, $fragment);
            }

            ArrayPath::mergeTo($path, $data, $includeData);

            return null;
        }

        return $next($value, $path, $data);
    }
}