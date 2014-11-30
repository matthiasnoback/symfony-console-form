<?php

namespace Matthias\SymfonyConsoleForm\Command;

use Matthias\SymfonyConsoleForm\Helper\FormQuestionHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @method setDefinition($definition)
 * @method HelperSet getHelperSet()
 */
trait InteractiveFormCapabilities
{
    /**
     * @var FormQuestionHelper|null
     */
    private $formQuestionHelper;
    private $formData;

    /**
     * Configure this command (the form fields will be automatically added as options)
     *
     * @return void
     */
    abstract protected function configureInteractiveFormCommand();

    /**
     * Execute this command in the regular way, except you also get the form data
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param $formData
     */
    abstract protected function executeInteractiveFormCommand(InputInterface $input, OutputInterface $output, $formData);

    /**
     * Return the form type which should be used for the form interaction of this command
     *
     * @return string|FormTypeInterface
     */
    abstract protected function formType();

    public function setFormQuestionHelper(FormQuestionHelper $formQuestionHelper)
    {
        $this->formQuestionHelper = $formQuestionHelper;
    }

    protected function configure()
    {
        $this->setDefinition($this->formQuestionHelper()->inputDefinition($this->formType()));

        $this->configureInteractiveFormCommand();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->executeInteractiveFormCommand($input, $output, $this->formData());
    }

    /**
     * By default interaction for this command consists of collecting data from the user based on the form type for this
     * command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->getHelperSet()->set($this->formQuestionHelper());

        $this->formData = $this->formQuestionHelper()->interactUsingForm($this->formType(), $input, $output);
    }

    private function formData()
    {
        if ($this->formData === null) {
            throw new \LogicException('Form data is not available, run this command in interactive mode');
        }

        return $this->formData;
    }

    protected function formQuestionHelper()
    {
        if ($this->formQuestionHelper === null) {
            throw new \LogicException('Please provide a FormQuestionHelper instance using setFormQuestionHelper');
        }

        return $this->formQuestionHelper;
    }
}
