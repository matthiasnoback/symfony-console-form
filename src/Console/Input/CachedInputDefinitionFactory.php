<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

use RuntimeException;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Console\Input\InputDefinition;

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

    public function __construct(InputDefinitionFactory $inputDefinitionFactory, string $cacheDirectory, bool $debug)
    {
        $this->inputDefinitionFactory = $inputDefinitionFactory;
        $this->cacheDirectory = $cacheDirectory;
        $this->debug = $debug;
    }

    public function createForFormType(string $formType, array &$resources = []): InputDefinition
    {
        $cache = $this->configCacheFor($formType);

        if ($cache->isFresh()) {
            return $this->inputDefinitionFromCache($cache->getPath());
        }

        return $this->freshInputDefinition($formType, $cache, $resources);
    }

    protected function configCacheFor(string $formType): ConfigCache
    {
        return new ConfigCache($this->cacheDirectory . '/' . $formType, $this->debug);
    }

    /**
     * @param string $cacheFile
     */
    private function inputDefinitionFromCache(string $cacheFile): InputDefinition
    {
        $unserialized = unserialize(file_get_contents($cacheFile));

        if (!$unserialized instanceof InputDefinition) {
            throw new RuntimeException('Expected to get an object of type InputDefinition from the cache');
        }

        return $unserialized;
    }

    private function freshInputDefinition(string $formType, ConfigCache $cache, array &$resources): InputDefinition
    {
        $inputDefinition = $this->inputDefinitionFactory->createForFormType($formType, $resources);
        $cache->write(serialize($inputDefinition), $resources);

        return $inputDefinition;
    }
}
