<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Console\Command\Command;

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

    public function createForCommand(Command $command, array &$resources = [])
    {
        $cache = $this->configCacheFor($command);

        if ($cache->isFresh()) {
            return $this->inputDefinitionFromCache($cache);
        } else {
            return $this->freshInputDefinition($command, $cache, $resources);
        }
    }

    protected function configCacheFor(Command $command)
    {
        $filename = str_replace('\\', '_', get_class($command));
        $cache = new ConfigCache($this->cacheDirectory . '/' . $filename, $this->debug);

        return $cache;
    }

    private function inputDefinitionFromCache($cache)
    {
        return unserialize(file_get_contents($cache));
    }

    private function freshInputDefinition(Command $command, ConfigCache $cache, array &$resources)
    {
        $inputDefinition = $this->inputDefinitionFactory->createForCommand($command, $resources);
        $cache->write(serialize($inputDefinition), $resources);

        return $inputDefinition;
    }
}
