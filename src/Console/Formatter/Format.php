<?php

namespace Matthias\SymfonyConsoleForm\Console\Formatter;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;

class Format
{
    public static function forQuestion($question, $defaultValue)
    {
        $default = $defaultValue ? strtr(
            ' [<default>{defaultValue}</default>]',
            ['{defaultValue}' => $defaultValue]
        ) : '';

        return strtr(
            '<question>{question}</question>{default}: ',
            [
                '{question}' => $question,
                '{default}' => $default
            ]
        );
    }

    public static function registerStyles(OutputInterface $output)
    {
        $formatter = $output->getFormatter();

        $formatter->setStyle('fieldset', new OutputFormatterStyle('yellow', null, array('bold')));
        $formatter->setStyle('default', new OutputFormatterStyle('green'));
        $formatter->setStyle('question', new OutputFormatterStyle('black', 'cyan'));
    }
}
