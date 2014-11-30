<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Matthias\SymfonyConsoleForm\Console\Helper\FormQuestionHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class InteractiveFormContainerAwareCommand extends ContainerAwareCommand implements FormBasedCommand
{
    use InteractiveFormCapabilities;

    public function __construct(FormQuestionHelper $formQuestionHelper)
    {
        $this->setFormQuestionHelper($formQuestionHelper);

        parent::__construct();
    }
}
