<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\FinalInternalClassFixer;
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
        // newlines
        MethodChainingNewlineFixer::class,
        NewlineServiceDefinitionConfigFixer::class,
        SpaceAfterCommaHereNowDocFixer::class,
        StandaloneLinePromotedPropertyFixer::class,
    ]);

    $ecsConfig->ruleWithConfiguration(GeneralPhpdocAnnotationRemoveFixer::class, [
        'annotations' => ['throws', 'author', 'package', 'group', 'covers', 'category'],
    ]);
};
