<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Bridge\Transformer\Exception\CouldNotResolveTransformer;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Form\FormInterface;

final class TypeAncestryBasedTransformerResolver implements TransformerResolver
{
    /**
     * @var FormToQuestionTransformer[]
     */
    private $transformers = [];

    public function addTransformer(string $formType, FormToQuestionTransformer $transformer): void
    {
        $this->transformers[$formType] = $transformer;
    }

    /**
     * @throws CouldNotResolveTransformer
     */
    public function resolve(FormInterface $form): FormToQuestionTransformer
    {
        $types = FormUtil::typeAncestry($form);

        foreach ($types as $type) {
            if (isset($this->transformers[$type])) {
                return $this->transformers[$type];
            }
        }

        throw new CouldNotResolveTransformer(
            sprintf(
                'Could not find a transformer for any of these types (%s)',
                implode(', ', $types)
            )
        );
    }
}
