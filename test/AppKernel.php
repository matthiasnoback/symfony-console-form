<?php

namespace Matthias\SymfonyConsoleForm\Tests;

use Matthias\SymfonyConsoleForm\Bundle\SymfonyConsoleFormBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new SymfonyConsoleFormBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config.yml');
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }

    public function getCacheDir(): string
    {
        return __DIR__.'/temp/cache';
    }

    public function getLogDir(): string
    {
        return __DIR__.'/temp/logs';
    }
}
