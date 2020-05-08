<?php

namespace Matthias\SymfonyConsoleForm\Bundle;

use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterOutputFormatterStylesPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $stylesCollectionId;

    /**
     * @var string
     */
    private $tagName;

    /**
     * @var string
     */
    private $styleNameAttribute;

    public function __construct(string $stylesCollectionId, string $tagName, string $styleNameAttribute)
    {
        $this->stylesCollectionId = $stylesCollectionId;
        $this->tagName = $tagName;
        $this->styleNameAttribute = $styleNameAttribute;
    }

    /**
     * @throws LogicException
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has($this->stylesCollectionId)) {
            throw new LogicException(
                sprintf(
                    'Style collection service "%s" is not defined',
                    $this->stylesCollectionId
                )
            );
        }

        $stylesCollection = $container->findDefinition($this->stylesCollectionId);

        foreach ($container->findTaggedServiceIds($this->tagName) as $serviceStyleId => $tags) {
            foreach ($tags as $tagAttributes) {
                if (!isset($tagAttributes[$this->styleNameAttribute])) {
                    throw new LogicException(
                        sprintf(
                            'Tag "%s" of service "%s" should have an attribute "%s"',
                            $this->tagName,
                            $serviceStyleId,
                            $this->styleNameAttribute
                        )
                    );
                }
                $name = $tagAttributes['style'];
                $stylesCollection->addMethodCall('set', [$name, new Reference($serviceStyleId)]);
            }
        }
    }
}
