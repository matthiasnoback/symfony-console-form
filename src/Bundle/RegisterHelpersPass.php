<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterHelpersPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $helperCollectionId;

    /**
     * @var string
     */
    private $tagName;

    /**
     * @param string $helperCollectionId
     * @param string $tagName
     */
    public function __construct($helperCollectionId, $tagName)
    {
        $this->helperCollectionId = $helperCollectionId;
        $this->tagName = $tagName;
    }

    /**
     * @param ContainerBuilder $container
     *
     * @throws \LogicException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has($this->helperCollectionId)) {
            throw new \LogicException(
                sprintf(
                    'Helper collection service "%s" is not defined',
                    $this->helperCollectionId
                )
            );
        }

        $helperCollection = $container->findDefinition($this->helperCollectionId);

        foreach ($container->findTaggedServiceIds($this->tagName) as $helperServiceId => $tags) {
            $helperCollection->addMethodCall('set', [new Reference($helperServiceId)]);
        }
    }
}
