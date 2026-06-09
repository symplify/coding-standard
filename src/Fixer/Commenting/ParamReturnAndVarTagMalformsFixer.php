<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Fixer\Commenting;

use PhpCsFixer\Fixer\DeprecatedFixerInterface;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;

/**
 * @deprecated This rule was split into single-task rules registered in config/sets/docblock.php.
 *             Use the docblock set or the dedicated rules instead.
 */
final class ParamReturnAndVarTagMalformsFixer extends AbstractSymplifyFixer implements DeprecatedFixerInterface
{
    private const string ERROR_MESSAGE = 'Fixes @param, @return, @var and inline @var annotations broken formats';

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function isCandidate(Tokens $tokens): bool
    {
        return false;
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function fix(SplFileInfo $fileInfo, Tokens $tokens): void
    {
    }

    /**
     * @return list<string>
     */
    public function getSuccessorsNames(): array
    {
        return [
            DoubleAsteriskInlineVarFixer::class,
            SingleLineInlineVarDocBlockFixer::class,
            AddMissingParamNameFixer::class,
            AddMissingVarNameFixer::class,
            RemoveParamNameReferenceFixer::class,
            FixParamNameTypoFixer::class,
            RemoveSuperfluousReturnNameFixer::class,
            RemoveSuperfluousVarNameFixer::class,
            SwitchedTypeAndNameFixer::class,
            RemoveDeadParamFixer::class,
        ];
    }
}
