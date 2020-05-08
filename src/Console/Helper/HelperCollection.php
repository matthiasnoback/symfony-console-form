<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper;

use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\HelperSet;

class HelperCollection
{
    /**
     * @var array & HelperInterface[]
     */
    private $helpers = [];

    public function set(HelperInterface $helper): void
    {
        $this->helpers[] = $helper;
    }

    public function addTo(HelperSet $helperSet): void
    {
        foreach ($this->helpers as $helper) {
            $helperSet->set($helper);
        }
    }
}
