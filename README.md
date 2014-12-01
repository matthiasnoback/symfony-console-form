# Symfony Console Form

By Matthias Noback

This package contains a Symfony bundle and some tools which enable you to use Symfony Form types to define and
interactively process user input from the CLI.

# Installation

    composer require matthiasnoback/symfony-console-form

Enable `Matthias\SymfonyConsoleForm\Bundle\SymfonyConsoleFormBundle` in the kernel of your Symfony application.

# Usage

Follow the steps below or just clone this project, then run:

    php test/console.php test

## Set up the form

```php
<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Email;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                [
                    'label' => 'Your name',
                    'required' => true,
                    'data' => 'Matthias'
                ]
            )
            ->add(
                'email',
                'email',
                [
                    'label' => 'Your email address',
                    'constraints' => [
                        new Email()
                    ]
                ]
            )
            ->add(
                'country',
                'country',
                [
                    'label' => 'Where do you live?',
                    'constraints' => [
                        new Country()
                    ]
                ]
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Matthias\SymfonyConsoleForm\Tests\FormData'
            ]
        );
    }

    public function getName()
    {
        return 'test';
    }
}
```

The corresponding `FormData` class looks like this:

```php
<?php

class FormData
{
    public $name;
    public $email;
    public $country;
}
```

## Create the console command

```php
<?php

use Matthias\SymfonyConsoleForm\Command\InteractiveFormContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends InteractiveFormContainerAwareCommand
{
    protected function configureInteractiveFormCommand()
    {
        $this->setName('test');

        // you don't need to configure any options here, this is all taken care of
    }

    protected function formType()
    {
        // return the form type (can be a string) which should be used for interaction with the user

        return new TestType();
    }

    protected function executeInteractiveFormCommand(InputInterface $input, OutputInterface $output, $formData)
    {
        // $formData is the valid and populated form data object

        ...
    }
}
```

Register the command as a service:

```yaml
services:
    matthias_symfony_console_form_test.test_command:
        class: TestCommand
        # you need to extend from this service
        parent: interactive_form_command
        tags:
            # you need to register the command as a service like this
            - { name: console.command }
```

Then run `app/console test` and you'll see the following interaction:

![](doc/interaction.png)

# TODO

- Provide example of stand-alone usage (no need to extend the command)
- Maybe: provide a way to submit a form at once, possibly using a JSON-encoded array
- Handle invalid form data (maybe in a loop)
- Extract auto-registering of formatter styles to a separate package
- Extract auto-registering of helpers to a separate package
- Use form event listener to interact or not (combine these into form interactors too)
- Don't copy form data to input options
- When these things have been provided, release this as a package (or multiple packages for stand-alone use)
