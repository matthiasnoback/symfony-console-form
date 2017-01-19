<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

interface InputDefinitionFactory
{
    /**
     * @param string|\Symfony\Component\Form\FormTypeInterface $formType
     * @param array                                            &$resources
     *
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    public function createForFormType($formType, array &$resources = []);
}
