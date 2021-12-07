<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Helper\HelperCollection;
use RuntimeException;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

final class RegisterHelpersEventListener
{
    /**
     * @var HelperCollection
     */
    private $helperCollection;

    public function __construct(HelperCollection $helperCollection)
    {
        $this->helperCollection = $helperCollection;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $command = $event->getCommand();

        if ($command === null) {
            throw new RuntimeException('Received ConsoleCommandEvent without Command instance!');
        }

        $helperSet = $command->getHelperSet();

        $this->helperCollection->addTo($helperSet);
    }
}
