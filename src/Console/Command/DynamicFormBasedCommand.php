<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

abstract class DynamicFormBasedCommand extends InteractiveFormCommand implements FormBasedCommand
{
    /**
     * @var string
     */
    private $formType;

    /**
     * @param string $formType
     */
    public function __construct($formType)
    {
        $this->formType = $formType;

        parent::__construct();
    }

    /**
     * @return string
     */
    public function formType()
    {
        return $this->formType;
    }

    /**
     * @return string
     */
    protected function configure()
    {
        $this->setName('form:'.$this->formType);
    }
}
