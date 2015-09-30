# Symfony Console Form

By Matthias Noback

[![Build Status](https://travis-ci.org/matthiasnoback/symfony-console-form.svg?branch=master)](https://travis-ci.org/matthiasnoback/symfony-console-form)

This package contains a Symfony bundle and some tools which enable you to use Symfony Form types to define and
interactively process user input from the CLI.

# Installation

    composer require matthiasnoback/symfony-console-form

Enable `Matthias\SymfonyConsoleForm\Bundle\SymfonyConsoleFormBundle` in the kernel of your Symfony application.
```php
    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Matthias\SymfonyConsoleForm\Bundle\SymfonyConsoleFormBundle(),
        );
    }
```

# Usage

Follow the steps below or just clone this project, then run:

    php test/console.php form:demo

## Set up the form

```php
<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Email;

class DemoType extends AbstractType
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
            ...
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'Matthias\SymfonyConsoleForm\Tests\Data\Demo']);
    }

    public function getName()
    {
        return 'test';
    }
}
```

The corresponding `Demo` class looks like this:

```php
<?php

class Demo
{
    public $name;
    ...
}
```

## Create the console command

### Strategy 1 (recommended): Use the `form` helper

```php
<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Matthias\SymfonyConsoleForm\Console\Helper\FormHelper;

class TestCommand extends Command implements FormBasedCommand
{
    protected function configure()
    {
        $this->setName('form:demo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formHelper = $this->getHelper('form');
        /** @var FormHelper $formHelper */

        $formData = $formHelper->interactUsingForm(new DemoType(), $input, $output);

        // $formData is the valid and populated form data object/array
        ...
    }
}
```

### Strategy 2: implement `FormBasedCommand`

You could also implement `FormBasedCommand`:

```php
<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommand;
use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommandCapabilities;

class TestCommand extends Command implements FormBasedCommand
{
    // use this trait to prevent code duplication
    use FormBasedCommandCapabilities;

    protected function configure()
    {
        $this->setName('form:demo');

        // you don't need to configure any options here, this is all taken care of
    }

    protected function formType()
    {
        // return the form type (can be a string) which should be used for interaction with the user

        return new DemoType();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formData = $this->formData();

        // $formData is the valid and populated form data object/array
        ...
    }
}
```

Then run `app/console form:demo` and you'll see the following interaction:

![](doc/interaction.png)

The first strategy is preferred since it allows you to interact with different forms instead of just one form (as is
the case when you pick the second strategy).

When you provide command-line options with the names of the form fields, those values will be used as default values.

If you add the `--no-interaction` option when running the command, it will submit the form using the input options you provided.

If the submitted data is invalid the command will fail.

# TODO

- Provide example of stand-alone usage (no need to extend the command)
- Maybe: provide a way to submit a form at once, possibly using a JSON-encoded array
- Handle invalid form data (maybe in a loop)
- Add more functional tests
- Show form label of root form
- Show nesting in form hierarchy using breadcrumbs
- Show counter when looping through a collection form
- When these things have been provided, release this as a package (or multiple packages for stand-alone use)
