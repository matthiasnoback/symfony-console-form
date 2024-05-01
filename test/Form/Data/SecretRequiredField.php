<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form\Data;

use Symfony\Component\Validator\Constraints as Assert;

class SecretRequiredField
{
    /**
     * @Assert\NotBlank()
     */
    #[Assert\NotBlank]
    public $name;

    /**
     * @Assert\NotBlank()
     */
    #[Assert\NotBlank]
    public $fieldNotUsedInTheForm;
}
