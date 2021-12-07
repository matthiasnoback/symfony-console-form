<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SymfonyConsoleFormBundle extends Bundle
{
    public function getContainerExtension(): SymfonyConsoleFormExtension
    {
        return new SymfonyConsoleFormExtension();
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterTransformersPass());

        $container->addCompilerPass(
            new RegisterHelpersPass(
                'matthias_symfony_console_form.helper_collection',
                'console_helper'
            )
        );
    }
}
