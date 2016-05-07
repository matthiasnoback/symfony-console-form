<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Symfony\Component\Form\FormInterface;

interface FormJsonTemplateInterface
{
    /**
     * @param FormInterface $form
     *
     * @return mixed
     */
    public function getAttributesWithFakeData(FormInterface $form);
}
