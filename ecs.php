<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/test',
    ]);

    $ecsConfig->skip([__DIR__ . '/test/temp']);

    $ecsConfig->sets([SetList::CONTROL_STRUCTURES, SetList::PSR_12]);
};
