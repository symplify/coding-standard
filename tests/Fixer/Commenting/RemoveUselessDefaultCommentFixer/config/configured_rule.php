<?php

declare(strict_types=1);
use PhpCsFixer\Fixer\Basic\BracesFixer;

use Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->rules([
        RemoveUselessDefaultCommentFixer::class,
        BracesFixer::class,
    ]);
};
