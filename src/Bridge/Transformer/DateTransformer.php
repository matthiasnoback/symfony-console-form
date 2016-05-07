<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormInterface;

class DateTransformer extends DateTimeTransformer
{
    public function getFakeData(FormInterface $form)
    {
        if ($form->getViewData()) {
            return $form->getViewData();
        }

        return (new \DateTime())->format('Y-m-d');
    }
}
