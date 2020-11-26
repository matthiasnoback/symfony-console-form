<?php declare(strict_types = 1);

namespace Matthias\SymfonyConsoleForm\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Addresses
{
    public $addresses;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }
}
