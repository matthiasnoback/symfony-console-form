<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

abstract class DynamicFormBasedCommand extends InteractiveFormCommand implements FormBasedCommand
{
    /**
     * @var string
     */
    private $formType;

    /**
     * @var string
     */
    private $commandName;

    /**
     * @param string $formType
     * @param string $commandName
     */
    public function __construct($formType, $commandName)
    {
        $this->formType = $formType;
        $this->commandName = $commandName;

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
        $this->setName('form:'.$this->commandName);
    }
}
