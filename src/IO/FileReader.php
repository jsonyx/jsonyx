<?php
namespace Jsonyx\IO;

use Jsonyx\Exception\InvalidArgumentException;

class FileReader implements ReaderInterface
{
    public function read(mixed $path): string
    {

        $this-> assertPath($path);

        return file_get_contents($path);
    }

    protected function assertPath(mixed $path): void
    {
        if (!is_string($path)) {
            throw new InvalidArgumentException('Path must be a string');
        }

        if (!file_exists($path)) {
            throw new InvalidArgumentException('File does not exist');
        }
    }
}