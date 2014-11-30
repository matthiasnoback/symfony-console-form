<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/TestKernel.php';

use Matthias\SymfonyConsoleForm\Tests\TestKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Debug\Debug;

Debug::enable();

$kernel = new TestKernel('dev', true);
$application = new Application($kernel);
$application->run();
