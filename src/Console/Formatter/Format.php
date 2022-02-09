<?php

namespace Matthias\SymfonyConsoleForm\Console\Formatter;

final class Format
{
    /**
     * @param mixed $defaultValue
     */
    public static function forQuestion(string $question, $defaultValue, ?string $help = null): string
    {
        $default = $defaultValue ? strtr(
            ' [{defaultValue}]',
            ['{defaultValue}' => (string)$defaultValue]
        ) : '';
        $help = $help !== null ? '<comment>' . $help . '</comment>' . "\n" : '';
        return strtr(
            '{help}<question>{question}</question>{default}: ',
            [
                '{help}' => $help,
                '{question}' => $question,
                '{default}' => (string)$default,
            ]
        );
    }
}
