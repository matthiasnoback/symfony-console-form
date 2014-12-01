<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper;

use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\HelperSet;

class HelperCollection
{
    private $helpers;

    public function set(HelperInterface $helper)
    {
        $this->helpers = $helper;
    }

    public function addTo(HelperSet $helperSet)
    {
        foreach ($this->helpers as $helper) {
            $helperSet->set($helper);
        }
    }
}
