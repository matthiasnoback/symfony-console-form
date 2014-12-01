<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class SymfonyConsoleFormExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');
        $loader->load('style.yml');
    }

    public function getAlias()
    {
        return 'symfony_console_form';
    }
}
