<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SymfonyConsoleFormExtension extends Extension
{
    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');
        $loader->load('style.yml');
        $loader->load('helpers.yml');
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'symfony_console_form';
    }
}
