<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Form\FormTypeInterface;

class CachedInputDefinitionFactory implements InputDefinitionFactory
{
    /**
     * @var InputDefinitionFactory
     */
    private $inputDefinitionFactory;

    /**
     * @var string
     */
    private $cacheDirectory;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param InputDefinitionFactory $inputDefinitionFactory
     * @param string                 $cacheDirectory
     * @param bool                   $debug
     */
    public function __construct(InputDefinitionFactory $inputDefinitionFactory, $cacheDirectory, $debug)
    {
        $this->inputDefinitionFactory = $inputDefinitionFactory;
        $this->cacheDirectory = $cacheDirectory;
        $this->debug = $debug;
    }

    /**
     * @param string|\Symfony\Component\Form\FormTypeInterface $formType
     * @param array                                            &$resources
     *
     * @return mixed
     */
    public function createForFormType($formType, array &$resources = [])
    {
        $cache = $this->configCacheFor($formType);

        if ($cache->isFresh()) {
            return $this->inputDefinitionFromCache($cache->getPath());
        }

        return $this->freshInputDefinition($formType, $cache, $resources);
    }

    /**
     * @param string|\Symfony\Component\Form\FormTypeInterface $formType
     *
     * @return ConfigCache
     */
    protected function configCacheFor($formType)
    {
        if ($formType instanceof FormTypeInterface) {
            $filename = get_class($formType);
        } elseif (is_string($formType)) {
            $filename = $formType;
        } else {
            throw new \LogicException('Unexpected type');
        }

        return new ConfigCache($this->cacheDirectory.'/'.$filename, $this->debug);
    }

    /**
     * @param string $cache
     *
     * @return mixed
     */
    private function inputDefinitionFromCache($cache)
    {
        return unserialize(file_get_contents($cache));
    }

    /**
     * @param string|\Symfony\Component\Form\FormTypeInterface $formType
     * @param ConfigCache                                      $cache
     * @param array                                            &$resources
     *
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    private function freshInputDefinition($formType, ConfigCache $cache, array &$resources)
    {
        $inputDefinition = $this->inputDefinitionFactory->createForFormType($formType, $resources);
        $cache->write(serialize($inputDefinition), $resources);

        return $inputDefinition;
    }
}
