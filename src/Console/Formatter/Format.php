<?php

namespace Matthias\SymfonyConsoleForm\Console\Formatter;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;

final class Format
{
    /**
     * @param mixed $defaultValue
     */
    public static function forQuestion(string $question, $defaultValue): string
    {
        $default = $defaultValue ? strtr(
            ' [<default>{defaultValue}</default>]',
            ['{defaultValue}' => (string)$defaultValue]
        ) : '';

        return strtr(
            '<question>{question}</question>{default}: ',
            [
                '{question}' => $question,
                '{default}' => (string)$default,
            ]
        );
    }

    public static function registerStyles(OutputInterface $output): void
    {
        $formatter = $output->getFormatter();

        $formatter->setStyle('fieldset', new OutputFormatterStyle('yellow', null, ['bold']));
        $formatter->setStyle('default', new OutputFormatterStyle('green'));
        $formatter->setStyle('question', new OutputFormatterStyle('black', 'cyan'));
    }
}
