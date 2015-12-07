<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Matthias\SymfonyConsoleForm\LegacyFormHelper;

abstract class DynamicFormBasedCommand extends InteractiveFormCommand implements FormBasedCommand
{
    /**
     * @var string
     */
    private $formType;

    /**
     * @var string
     */
    private $formTypeName;

    /**
     * @param string $formType
     * @param string $formTypeName
     */
    public function __construct($formType, $formTypeName)
    {
        $this->formType = $formType;
        $this->formTypeName = $formTypeName;

        parent::__construct();
    }

    /**
     * @return string
     */
    public function formType()
    {
        return LegacyFormHelper::getType($this->formType, $this->formTypeName);
    }

    /**
     * @return string
     */
    protected function configure()
    {
        $this->setName('form:'.$this->formTypeName);
    }
}
