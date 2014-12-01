<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

interface FormBasedCommand
{
    public function formType();

    public function setFormData($data);
}
