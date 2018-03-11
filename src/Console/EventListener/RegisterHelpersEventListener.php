<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Helper\HelperCollection;
use RuntimeException;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class RegisterHelpersEventListener
{
    /**
     * @var HelperCollection
     */
    private $helperCollection;

    /**
     * @param HelperCollection $helperCollection
     */
    public function __construct(HelperCollection $helperCollection)
    {
        $this->helperCollection = $helperCollection;
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();

        if (null === $command) {
            throw new RuntimeException('Received ConsoleCommandEvent without Command instance!');
        }

        $helperSet = $command->getHelperSet();

        $this->helperCollection->addTo($helperSet);
    }
}
