<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Helper\HelperCollection;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class RegisterHelpersEventListener
{
    private $helperCollection;

    public function __construct(HelperCollection $helperCollection)
    {
        $this->helperCollection = $helperCollection;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $helperSet = $event->getCommand()->getHelperSet();

        $this->helperCollection->addTo($helperSet);
    }
}
