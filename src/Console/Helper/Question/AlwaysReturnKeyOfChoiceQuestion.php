<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper\Question;

use Symfony\Component\Console\Question\ChoiceQuestion;

class AlwaysReturnKeyOfChoiceQuestion extends ChoiceQuestion
{
    private $_multiselect = false;

    private $_errorMessage = 'Value "%s" is invalid';

    public function setMultiselect($multiselect)
    {
        $this->_multiselect = $multiselect;

        return parent::setMultiselect($multiselect);
    }

    public function setErrorMessage($errorMessage)
    {
        $this->_errorMessage = $errorMessage;

        return parent::setErrorMessage($errorMessage);
    }

    public function getValidator()
    {
        $choices = $this->getChoices();
        $errorMessage = $this->_errorMessage;
        $multiselect = $this->_multiselect;

        return function ($selected) use ($choices, $errorMessage, $multiselect) {
            // Collapse all spaces.
            $selectedChoices = str_replace(' ', '', $selected);

            if ($multiselect) {
                // Check for a separated comma values
                if (!preg_match('/^[a-zA-Z0-9_-]+(?:,[a-zA-Z0-9_-]+)*$/', $selectedChoices, $matches)) {
                    throw new \InvalidArgumentException(sprintf($errorMessage, $selected));
                }
                $selectedChoices = explode(',', $selectedChoices);
            } else {
                $selectedChoices = array($selected);
            }

            $selectedKeys = array();

            foreach ($selectedChoices as $value) {
                if (array_key_exists($value, $choices)) {
                    $selectedKeys[] = $value;
                    continue;
                }

                $key = array_search($value, $choices);
                if ($key === false) {
                    throw new \InvalidArgumentException(sprintf($errorMessage, $value));
                }

                $selectedKeys[] = $key;
            }

            if ($multiselect) {
                return $selectedKeys;
            }

            return current($selectedKeys);
        };
    }
}
