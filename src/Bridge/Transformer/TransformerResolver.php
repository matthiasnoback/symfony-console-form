<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Bridge\Transformer\Exception\CouldNotResolveTransformer;
use Symfony\Component\Form\FormInterface;

interface TransformerResolver
{
    /**
     * @param FormInterface $form
     * @return FormToQuestionTransformer
     * @throws CouldNotResolveTransformer
     */
    public function resolve(FormInterface $form);
}
