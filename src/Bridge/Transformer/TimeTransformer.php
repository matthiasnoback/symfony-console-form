<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormInterface;

class TimeTransformer extends DateTimeTransformer
{
    public function getFakeData(FormInterface $form)
    {
        if ($form->getViewData()) {
            return $form->getViewData();
        }

        return (new \DateTime())->format('H:m:s');
    }
}
