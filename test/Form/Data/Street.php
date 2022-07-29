<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form\Data;

class Street implements \Stringable
{
    public string $value;

    public function __construct(string $street)
    {
        $this->value = $street;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
