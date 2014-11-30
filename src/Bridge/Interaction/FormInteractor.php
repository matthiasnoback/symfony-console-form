<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

interface FormInteractor
{
    public function interactWith(
        FormInterface $form,
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output
    );
}
