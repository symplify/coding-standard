<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Operator\NewWithParenthesesFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->rules([
        LineLengthFixer::class,
    ]);

    $ecsConfig->ruleWithConfiguration(NewWithParenthesesFixer::class, [
        'anonymous_class' => false,
        'named_class' => false,
    ]);
};