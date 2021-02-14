<?php

namespace Matthias\SymfonyConsoleForm\Console\Formatter;

final class Format
{
    /**
     * @param mixed $defaultValue
     */
    public static function forQuestion(string $question, $defaultValue): string
    {
        $default = $defaultValue ? strtr(
            ' [{defaultValue}]',
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
}
