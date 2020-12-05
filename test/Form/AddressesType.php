<?php declare(strict_types = 1);

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Matthias\SymfonyConsoleForm\Tests\Model\Addresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'addresses',
            CollectionType::class,
            [
                'entry_type' => AddressType::class,
                'allow_add'  => true,
                'empty_data' => new ArrayCollection()
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Addresses::class);
    }
}
