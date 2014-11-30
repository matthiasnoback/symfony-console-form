<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterTransformersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $formQuestionHelper = $container->getDefinition('matthias_symfony_console_form.form_question_helper');
        foreach ($container->findTaggedServiceIds('form_to_question_transformer') as $serviceId => $tags) {
            foreach ($tags as $tagAttributes) {
                $formType = $tagAttributes['form_type'];
                $formQuestionHelper->addMethodCall('addTransformer', array($formType, new Reference($serviceId)));
            }
        }
    }
}
