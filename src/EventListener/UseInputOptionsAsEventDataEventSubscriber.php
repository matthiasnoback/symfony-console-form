<?php

namespace Matthias\SymfonyConsoleForm\EventListener;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class UseInputOptionsAsEventDataEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SUBMIT => 'onPreSubmit'
        );
    }

    public function onPreSubmit(FormEvent $event)
    {
        $input = $event->getData();
        if (!($input instanceof InputInterface)) {
            return;
        }

        $event->setData($this->convertInputToSubmittedData($input, $event->getForm()));
    }

    private function convertInputToSubmittedData(InputInterface $input, FormInterface $form)
    {
        $submittedData = [];

        // we don't need to do this recursively, since command options are one-dimensional (or are they?)
        foreach ($form->all() as $name => $field) {
            if ($input->hasOption($name)) {
                $submittedData[$name] = $input->getOption($name);
            }
        }

        return $submittedData;
    }
}
