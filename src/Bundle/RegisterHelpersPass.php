<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterHelpersPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $helperCollectionId;

    /**
     * @var string
     */
    private $tagName;

    public function __construct(string $helperCollectionId, string $tagName)
    {
        $this->helperCollectionId = $helperCollectionId;
        $this->tagName = $tagName;
    }

    /**
     * @throws LogicException
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has($this->helperCollectionId)) {
            throw new LogicException(
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
