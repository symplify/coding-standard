<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->rule(RemoveUselessDefaultCommentFixer::class);
    $ecsConfig->rule(StatementIndentationFixer::class);
};
