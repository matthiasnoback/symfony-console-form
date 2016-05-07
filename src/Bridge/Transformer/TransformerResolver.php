<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Bridge\Transformer\Exception\CouldNotResolveTransformer;
use Symfony\Component\Form\FormInterface;

interface TransformerResolver
{
    /**
     * @param FormInterface $form
     *
     * @throws CouldNotResolveTransformer
     *
     * @return FormToQuestionTransformer
     */
    public function resolve(FormInterface $form);

    /**
     * @param FormInterface $form
     *
     * @throws CouldNotResolveTransformer
     *
     * @return FakeDataTransformerInterface
     */
    public function resolveForFakeData(FormInterface $form);
}
