<?php

namespace Matthias\SymfonyConsoleForm\Form\EventListener;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class UseInputOptionsAsEventDataEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        ];
    }

    public function onPreSubmit(FormEvent $event): void
    {
        $input = $event->getData();
        if (!($input instanceof InputInterface)) {
            return;
        }

        $event->setData($this->convertInputToSubmittedData($input, $event->getForm()));
    }

    private function convertInputToSubmittedData(InputInterface $input, FormInterface $form, ?string $name = null): mixed
    {
        $submittedData = null;
        if ($form->getConfig()->getCompound()) {
            $submittedData = [];
            $repeatedField = $form->getConfig()->getType()->getInnerType() instanceof RepeatedType;
            foreach ($form->all() as $childName => $field) {
                if ($repeatedField) {
                    $submittedData = $this->convertInputToSubmittedData($input, $field, $name ?? $form->getName());
                } else {
                    $subName = $name === null ? $childName : $name . '[' . $childName . ']';
                    $submittedData[$childName] = $this->convertInputToSubmittedData($input, $field, $subName);
                }
            }
        } else {
            $name = $name ?? $form->getName();
            if ($input->hasOption($name)) {
                return $input->getOption($name);
            }
        }

        return $submittedData;
    }
}
