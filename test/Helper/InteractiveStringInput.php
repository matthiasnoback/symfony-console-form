<?php

namespace Matthias\SymfonyConsoleForm\Tests\Helper;

use Symfony\Component\Console\Input\StringInput;

/**
 * Copied from https://github.com/phpspec/phpspec/blob/master/features/bootstrap/Console/InteractiveStringInput.php.
 */
class InteractiveStringInput extends StringInput
{
    public function setInteractive($interactive)
    {
        // this function is disabled to prevent setting non interactive mode on string input after posix_isatty return false
    }
}
