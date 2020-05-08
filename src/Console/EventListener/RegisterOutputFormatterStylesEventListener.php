<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Formatter\StylesCollection;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

final class RegisterOutputFormatterStylesEventListener
{
    /**
     * @var StylesCollection
     */
    private $styles;

    public function __construct(StylesCollection $styles)
    {
        $this->styles = $styles;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $outputFormatter = $event->getOutput()->getFormatter();

        $this->styles->applyTo($outputFormatter);
    }
}
