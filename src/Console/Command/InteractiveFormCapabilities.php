<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Matthias\SymfonyConsoleForm\Console\Helper\FormQuestionHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @method setDefinition($definition)
 * @method HelperSet getHelperSet()
 * @method string getName()
 * @method string|FormTypeInterface formType()
 */
trait InteractiveFormCapabilities
{
    /**
     * @var \Matthias\SymfonyConsoleForm\Console\Helper\FormQuestionHelper|null
     */
    private $formQuestionHelper;
    private $formData;

    /**
     * Configure this command (the form fields will be automatically added as options)
     *
     * @return void
     */
    abstract protected function configureInteractiveFormCommand();

    public function setFormQuestionHelper(FormQuestionHelper $formQuestionHelper)
    {
        $this->formQuestionHelper = $formQuestionHelper;
    }

    protected function configure()
    {
        $this->setDefinition($this->formQuestionHelper()->inputDefinition($this));

        $this->configureInteractiveFormCommand();
    }

    /**
     * @return FormQuestionHelper
     */
    protected function formQuestionHelper()
    {
        if ($this->formQuestionHelper === null) {
            throw new \LogicException('Please provide a FormQuestionHelper instance using setFormQuestionHelper');
        }

        return $this->formQuestionHelper;
    }

    public function setFormData($data)
    {
        $this->formData = $data;
    }
}
