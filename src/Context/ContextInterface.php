<?php
namespace Jsonyx\Context;

interface ContextInterface
{
    public function get(string $name): mixed;
    public function set(string $name, mixed $value): static;
    public function add(array $data): static;

    public function chdir(string $name): static;
    public function pwd(): string;
}