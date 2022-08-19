<?php

declare(strict_types=1);

namespace Matthias\SymfonyConsoleForm\Tests\Form\Data;

final class User
{
    public string $name;
    public string $lastName;

    public function __toString(): string
    {
        return 'name: ' . $this->name . ', lastName: ' . $this->lastName;
    }
}
