<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\FormNotReadyForInteraction;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormInterface;

class JsonDataInteractor implements FormInteractor
{
    /**
     * @param FormInterface   $form
     * @param HelperSet       $helperSet
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception\FormNotReadyForInteraction
     * @throws Exception\CanNotInteractWithForm
     *
     * @return InputInterface
     */
    public function interactWith(
        FormInterface $form,
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
        if (!$form->isRoot()) {
            throw new CanNotInteractWithForm('This interactor only works with root forms');
        }

        $jsonString = null;

        if ($jsonDataFile = $input->getOption('json-data-file')) {
            $fsystem = new Filesystem();
            if ($fsystem->exists($jsonDataFile)) {
                $jsonString = file_get_contents($jsonDataFile);
            }
        }

        if (!$jsonString && !$jsonString = $input->getOption('json-data')) {
            throw new CanNotInteractWithForm('json-data or json-data-file option are required');
        }

        if (!$json = json_decode($jsonString, true)) {
            throw new FormNotReadyForInteraction('Invalid json format "json-data"');
        }

        if (!isset($json[$form->getName()])) {
            throw new CanNotInteractWithForm('The json does not have the attribute concerning the form');
        }

        return $json[$form->getName()];
    }
}
