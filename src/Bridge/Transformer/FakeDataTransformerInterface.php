<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormInterface;

/**
 * Transform the given form (field) to a Question used by the Console Component to interact with the user.
 */
interface FakeDataTransformerInterface
{
    /**
     * Used to auto-fill form data used in JsonFormTemplateCommand.
     *
     * @param FormInterface $form
     *
     * @return mixed
     */
    public function getFakeData(FormInterface $form);
}
