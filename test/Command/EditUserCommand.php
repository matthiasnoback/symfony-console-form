<?php
declare(strict_types=1);

namespace Matthias\SymfonyConsoleForm\Tests\Command;

use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommandWithDefault;
use Matthias\SymfonyConsoleForm\Tests\Form\Data\User;

final class EditUserCommand extends PrintFormDataCommand implements FormBasedCommandWithDefault
{
    public function getFormDefault()
    {
        $user = new User();
        $user->name = 'Mario';
        $user->lastName = 'Rossi';

        return $user;
    }
}
