<?php

namespace Jsonyx\IO;

interface ReaderInterface
{
    public function read(mixed $source): string;
}