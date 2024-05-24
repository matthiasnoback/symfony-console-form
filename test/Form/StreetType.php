<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Matthias\SymfonyConsoleForm\Tests\Form\Data\Address;
use Matthias\SymfonyConsoleForm\Tests\Form\Data\Street;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StreetType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this);
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function transform(mixed $value): mixed
    {
        return (string)$value;
    }

    public function reverseTransform(mixed $value): mixed
    {
        return new Street((string)$value);
    }
}
