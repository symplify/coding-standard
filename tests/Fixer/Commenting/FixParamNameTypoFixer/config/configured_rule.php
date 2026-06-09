<?php

declare(strict_types=1);

use Symplify\CodingStandard\Fixer\Commenting\FixParamNameTypoFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->rule(FixParamNameTypoFixer::class);
};
