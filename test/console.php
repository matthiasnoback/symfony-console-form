<?php

require __DIR__ . '/../vendor/autoload.php';

use Matthias\SymfonyConsoleForm\Tests\AppKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Debug\Debug;

Debug::enable();

$kernel = new AppKernel('dev', true);
$application = new Application($kernel);
$application->run();
