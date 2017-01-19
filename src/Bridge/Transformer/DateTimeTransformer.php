<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormInterface;

class DateTimeTransformer extends TextTransformer
{
    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getViewData();
    }

    public function getFakeData(FormInterface $form)
    {
        if ($form->getViewData()) {
            return $form->getViewData();
        }

        return (new \DateTime())->format('Y-m-d H:m:s');
    }
}
