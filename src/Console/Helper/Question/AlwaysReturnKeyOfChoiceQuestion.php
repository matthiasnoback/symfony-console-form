<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper\Question;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;

class AlwaysReturnKeyOfChoiceQuestion extends ChoiceQuestion
{
    /**
     * @var ChoiceView[]
     */
    private $choiceViews;
    private $_multiselect = false;

    private $_errorMessage = 'Value "%s" is invalid';

    public function __construct($question, array $choiceViews, $default = null)
    {
        $this->assertFlatChoiceViewsArray($choiceViews);

        $this->choiceViews = $choiceViews;

        parent::__construct($question, $this->prepareChoices(), $default);

        $this->setAutocompleterValues($this->prepareAutocompleteValues());
    }

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
        return function ($selected) {
            // Collapse all spaces.
            $selectedChoices = str_replace(' ', '', $selected);

            if ($this->_multiselect) {
                // Check for a separated comma values
                if (!preg_match('/^[a-zA-Z0-9_-]+(?:,[a-zA-Z0-9_-]+)*$/', $selectedChoices, $matches)) {
                    throw new \InvalidArgumentException(sprintf($this->_errorMessage, $selected));
                }
                $selectedChoices = explode(',', $selectedChoices);
            } else {
                $selectedChoices = array($selected);
            }

            $selectedKeys = array();

            foreach ($selectedChoices as $selectedValue) {
                $selectedKeys[] = $this->resolveChoiceViewValue($selectedValue);
            }

            if ($this->_multiselect) {
                return $selectedKeys;
            }

            return current($selectedKeys);
        };
    }

    /**
     * @param string $selectedValue The selected value
     * @return string The corresponding value of the ChoiceView
     */
    private function resolveChoiceViewValue($selectedValue)
    {
        foreach ($this->choiceViews as $choiceView) {
            if (in_array($selectedValue, [$choiceView->data, $choiceView->value, $choiceView->label])) {
                return $choiceView->value;
            }
        }

        throw new \InvalidArgumentException(sprintf($this->_errorMessage, $selectedValue));
    }

    private function prepareChoices()
    {
        $choices = [];
        foreach ($this->choiceViews as $choiceView) {
            $label = $choiceView->label;
            if ($choiceView->data != $choiceView->value) {
                $label .= ' (<comment>' . $choiceView->data . '</comment>)';
            }

            $choices[$choiceView->value] = $label;
        }

        return $choices;
    }

    private function prepareAutocompleteValues()
    {
        $autocompleteValues = array();

        foreach ($this->choiceViews as $choiceView) {
            $autocompleteValues[] = $choiceView->value;
            $autocompleteValues[] = $choiceView->data;
            $autocompleteValues[] = $choiceView->label;
        }

        return $autocompleteValues;
    }

    private function assertFlatChoiceViewsArray(array $choiceViews)
    {
        foreach ($choiceViews as $choiceView) {
            if (!$choiceView instanceof ChoiceView) {
                throw new \InvalidArgumentException('Only a flat choice hierarchy is supported');
            }
        }
    }
}
