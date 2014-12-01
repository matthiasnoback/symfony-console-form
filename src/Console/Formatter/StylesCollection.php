<?php

namespace Matthias\SymfonyConsoleForm\Console\Formatter;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;

class StylesCollection
{
    /**
     * @var OutputFormatterStyleInterface[]
     */
    private $styles = array();

    public function set($name, OutputFormatterStyleInterface $style)
    {
        $this->styles[$name] = $style;
    }

    public function applyTo(OutputFormatterInterface $outputFormatter)
    {
        foreach ($this->styles as $name => $style) {
            $outputFormatter->setStyle($name, $style);
        }
    }
}
