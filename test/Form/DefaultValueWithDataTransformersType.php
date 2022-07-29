<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Matthias\SymfonyConsoleForm\Tests\Form\Data\Address;
use Matthias\SymfonyConsoleForm\Tests\Form\Data\Street;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DefaultValueWithDataTransformersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', StreetType::class, [
                'label' => 'Street'
            ]);
    }
}
