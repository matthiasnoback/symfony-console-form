<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

interface FormBasedCommand
{
    /**
     * @return mixed
     */
    public function formType();

    /**
     * @param mixed $data
     */
    public function setFormData($data);
}
