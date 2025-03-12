<?php
namespace Jsonyx\Context;

use Jsonyx\Mix\ArrayPath;

class Context implements ContextInterface
{
    private array $data = [];
    private string $pwd = '';

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function reset(): static
    {
        $this->data = [];

        return $this;
    }

    public function get(string $name): mixed
    {
        return ArrayPath::get($this->data, $name);
    }

    public function add( array $data): static
    {
        $this->data = ArrayPath::merge($this->data, $data);

        return $this;
    }



    public function set(string $name, mixed $value): static
    {
        ArrayPath::set($this->data, $name, $value);

        return $this;
    }

    public function chdir(string $name): static
    {
        $this->pwd = $name;

        return $this;
    }

    public function pwd(): string
    {
        return $this->pwd;
    }
 
}