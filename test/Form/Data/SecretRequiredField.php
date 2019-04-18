<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form\Data;

use Symfony\Component\Validator\Constraints as Assert;

class SecretRequiredField
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\NotBlank()
     */
    public $fieldNotUsedInTheForm;
}
