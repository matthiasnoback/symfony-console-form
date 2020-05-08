<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

interface FormBasedCommand
{
    public function formType(): string;

    /**
     * @param mixed $data
     */
    public function setFormData($data);
}
