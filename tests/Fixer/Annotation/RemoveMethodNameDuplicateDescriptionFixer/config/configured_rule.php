<?php

declare(strict_types=1);

use Symplify\CodingStandard\Fixer\Annotation\RemoveMethodNameDuplicateDescriptionFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->rules([
        RemoveMethodNameDuplicateDescriptionFixer::class,
    ]);
};
