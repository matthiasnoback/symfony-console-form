<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form\Data;

class Address
{
    public $street;

    /**
     * @param $street
     */
    public function __construct($street)
    {
        $this->street = $street;
    }
}
