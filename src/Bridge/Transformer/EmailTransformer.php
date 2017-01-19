<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormInterface;

class EmailTransformer extends TextTransformer
{
    public function getFakeData(FormInterface $form)
    {
        if ($form->getViewData()) {
            return $form->getViewData();
        }

        return 'dummy@dummy.com';
    }
}
