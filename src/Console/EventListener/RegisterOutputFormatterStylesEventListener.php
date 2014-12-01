<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Formatter\StylesCollection;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class RegisterOutputFormatterStylesEventListener
{
    private $styles;

    public function __construct(StylesCollection $styles)
    {
        $this->styles = $styles;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $outputFormatter = $event->getOutput()->getFormatter();

        $this->styles->applyTo($outputFormatter);
    }
}
