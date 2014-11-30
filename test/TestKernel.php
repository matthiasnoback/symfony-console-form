<?php

namespace Matthias\SymfonyConsoleForm\Tests;

use Matthias\SymfonyConsoleForm\Bundle\SymfonyConsoleFormBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function registerBundles()
    {
        return array(
            new FrameworkBundle(),
            new SymfonyConsoleFormBundle()
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
    }
}
