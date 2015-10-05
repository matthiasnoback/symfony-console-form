<?php
$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in('src')
    ->in('test')
    ->notPath('temp');
$config = Symfony\CS\Config\Config::create();
$config->fixers(['ordered_use']);
$config->finder($finder);
return $config;
