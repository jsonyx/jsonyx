<?php
namespace Jsonyx\Plugin\Value;

use Exrray\Exrray;
use Jsonyx\Plugin\AbstractPlugin;

class IncludePlugin extends AbstractPlugin
{
    const PATTERN = '/@include\((.*?)\)/i';

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
                $value = Exrray::get($value, $fragment);
            }
        }

        return $next($value, $path, $data);
    }
}