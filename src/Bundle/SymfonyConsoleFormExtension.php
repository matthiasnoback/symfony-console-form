<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class SymfonyConsoleFormExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');
        $loader->load('helpers.yml');
    }

    public function getAlias(): string
    {
        return 'symfony_console_form';
    }
}
