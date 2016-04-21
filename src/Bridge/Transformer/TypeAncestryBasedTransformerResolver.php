<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Bridge\Transformer\Exception\CouldNotResolveTransformer;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Form\FormInterface;

class TypeAncestryBasedTransformerResolver implements TransformerResolver
{
    /**
     * @var FormToQuestionTransformer[]
     */
    private $transformers = [];

    /**
     * @param string                    $formType
     * @param FormToQuestionTransformer $transformer
     */
    public function addTransformer($formType, FormToQuestionTransformer $transformer)
    {
        $this->transformers[$formType] = $transformer;
    }

    /**
     * @param FormInterface $form
     *
     * @throws CouldNotResolveTransformer
     *
     * @return FormToQuestionTransformer
     */
    public function resolve(FormInterface $form)
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
