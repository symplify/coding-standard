<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;
use Symplify\CodingStandard\Fixer\Spacing\NewlineServiceDefinitionConfigFixer;
use Symplify\CodingStandard\Fixer\Spacing\SpaceAfterCommaHereNowDocFixer;
use Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import(__DIR__ . '/config.php');

    // epxpclit like other configs :) no magic!!!

    $ecsConfig->rules([
        // docblocks and comments
        \Symplify\CodingStandard\Fixer\Annotation\RemovePHPStormAnnotationFixer::class,
        \Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer::class,
        \Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer::class,

        // arrays
        \Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer::class,
        \Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer::class,
        StandaloneLinePromotedPropertyFixer::class,

        // newlines
        MethodChainingNewlineFixer::class,
        NewlineServiceDefinitionConfigFixer::class,
        SpaceAfterCommaHereNowDocFixer::class,
        StandaloneLinePromotedPropertyFixer::class,
        \Symplify\CodingStandard\Fixer\Strict\BlankLineAfterStrictTypesFixer::class,

        // line length
        \Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer::class,

        // naming
        \Symplify\CodingStandard\Fixer\Naming\StandardizeHereNowDocKeywordFixer::class,

    ]);

    $ecsConfig->ruleWithConfiguration(GeneralPhpdocAnnotationRemoveFixer::class, [
        'annotations' => ['throws', 'author', 'package', 'group', 'covers', 'category'],
    ]);
};
