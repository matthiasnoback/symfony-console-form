<?php
declare( strict_types=1 );

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\FormInterface;

class FileFormTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form): Question
    {
        $question = new Question(
            $this->questionFrom($form),
            $this->defaultValueFrom($form)
        );
        $question->setNormalizer(function($value) {
            return new \Symfony\Component\HttpFoundation\File\File($value);
        });
        return $question;
    }

    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getViewData();
    }
}
