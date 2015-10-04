<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

interface InputDefinitionFactory
{
    /**
     * @param string|\Symfony\Component\Form\FormTypeInterface $formType
     * @param array                                            &$resources
     */
    public function createForFormType($formType, array &$resources = []);
}
