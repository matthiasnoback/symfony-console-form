<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Form\FormTypeInterface;

class CachedInputDefinitionFactory implements InputDefinitionFactory
{
    private $inputDefinitionFactory;
    private $cacheDirectory;
    private $debug;

    public function __construct(InputDefinitionFactory $inputDefinitionFactory, $cacheDirectory, $debug)
    {
        $this->inputDefinitionFactory = $inputDefinitionFactory;
        $this->cacheDirectory = $cacheDirectory;
        $this->debug = $debug;
    }

    public function createForFormType($formType, array &$resources = [])
    {
        $cache = $this->configCacheFor($formType);

        if ($cache->isFresh()) {
            return $this->inputDefinitionFromCache($cache);
        } else {
            return $this->freshInputDefinition($formType, $cache, $resources);
        }
    }

    protected function configCacheFor($formType)
    {
        $filename = $formType instanceof FormTypeInterface ? $formType->getName() : $formType;

        $cache = new ConfigCache($this->cacheDirectory . '/' . $filename, $this->debug);

        return $cache;
    }

    private function inputDefinitionFromCache($cache)
    {
        return unserialize(file_get_contents($cache));
    }

    private function freshInputDefinition($formType, ConfigCache $cache, array &$resources)
    {
        $inputDefinition = $this->inputDefinitionFactory->createForFormType($formType, $resources);
        $cache->write(serialize($inputDefinition), $resources);

        return $inputDefinition;
    }
}
