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

    public function __construct(string $formType, string $commandName)
    {
        $this->formType = $formType;
        $this->commandName = $commandName;

        parent::__construct();
    }

    public function formType(): string
    {
        return $this->formType;
    }

    protected function configure(): void
    {
        $this->setName('form:'.$this->commandName);
    }
}
