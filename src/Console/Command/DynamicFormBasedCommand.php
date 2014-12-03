<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

abstract class DynamicFormBasedCommand extends InteractiveFormCommand implements FormBasedCommand
{
    private $formType;

    public function __construct($formType)
    {
        $this->formType = $formType;

        parent::__construct();
    }

    public function formType()
    {
        return $this->formType;
    }

    protected function configure()
    {
        $this->setName('form:' . $this->formType);
    }
}
