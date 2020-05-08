<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymfonyConsoleFormBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SymfonyConsoleFormExtension();
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterTransformersPass());

        $container->addCompilerPass(
            new RegisterOutputFormatterStylesPass(
                'matthias_symfony_console.styles_collection',
                'console_style',
                'style'
            )
        );

        $container->addCompilerPass(
            new RegisterHelpersPass(
                'matthias_symfony_console_form.helper_collection',
                'console_helper'
            )
        );
    }
}
