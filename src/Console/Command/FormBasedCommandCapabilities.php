<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

trait FormBasedCommandCapabilities
{
    private $formData;

    protected function formData()
    {
        if ($this->formData === null) {
            if (!($this instanceof FormBasedCommand)) {
                throw new \LogicException(
                    'Your command should be an instance of FormBasedCommand'
                );
            }

            throw new \LogicException('For some reason, no form data was set');
        }

        return $this->formData;
    }

    public function setFormData($data)
    {
        $this->formData = $data;
    }
}
