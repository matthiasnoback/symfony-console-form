<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use LogicException;

trait FormBasedCommandCapabilities
{
    /**
     * @var mixed
     */
    private $formData;

    /**
     * @return mixed
     */
    protected function formData()
    {
        if ($this->formData === null) {
            if (!($this instanceof FormBasedCommand)) {
                throw new LogicException(
                    'Your command should be an instance of FormBasedCommand'
                );
            }

            throw new LogicException('For some reason, no form data was set');
        }

        return $this->formData;
    }

    /**
     * @param mixed $data
     */
    public function setFormData($data): void
    {
        $this->formData = $data;
    }
}
