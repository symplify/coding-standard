<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Fixer\ArrayNotation;

use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;
use Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\BlockFinder;
use Symplify\CodingStandard\TokenRunner\Enum\LineKind;
use Symplify\CodingStandard\TokenRunner\Transformer\FixerTransformer\TokensNewliner;
use Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo;
use Symplify\CodingStandard\TokenRunner\ValueObject\TokenKinds;
use Symplify\CodingStandard\TokenRunner\Wrapper\FixerWrapper\ArrayWrapperFactory;

/**
 * @see \Symplify\CodingStandard\Tests\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer\StandaloneLineInMultilineArrayFixerTest
 */
final class StandaloneLineInMultilineArrayFixer extends AbstractSymplifyFixer
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Indexed arrays must have 1 item per line';

    public function __construct(
        private readonly ArrayWrapperFactory $arrayWrapperFactory,
        private readonly TokensNewliner $tokensNewliner,
        private readonly BlockFinder $blockFinder
    ) {
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }

    /**
     * Must run before
     *
     * @see \PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer::getPriority()
     */
    public function getPriority(): int
    {
        return 5;
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function isCandidate(Tokens $tokens): bool
    {
        if (! $tokens->isAnyTokenKindsFound(TokenKinds::ARRAY_OPEN_TOKENS)) {
            return false;
        }

        return $tokens->isTokenKindFound(T_DOUBLE_ARROW);
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function fix(SplFileInfo $fileInfo, Tokens $tokens): void
    {
        foreach ($tokens as $index => $token) {
            if (! $token->isGivenKind(TokenKinds::ARRAY_OPEN_TOKENS)) {
                continue;
            }

            $blockInfo = $this->blockFinder->findInTokensByEdge($tokens, $index);
            if (! $blockInfo instanceof BlockInfo) {
                continue;
            }

            if ($this->shouldSkipNestedArrayValue($tokens, $blockInfo)) {
                return;
            }

            $this->tokensNewliner->breakItems($blockInfo, $tokens, LineKind::ARRAYS);
        }
    }

    /**
     * @param Tokens<Token> $tokens
     */
    private function shouldSkipNestedArrayValue(Tokens $tokens, BlockInfo $blockInfo): bool
    {
        $arrayWrapper = $this->arrayWrapperFactory->createFromTokensAndBlockInfo($tokens, $blockInfo);
        if (! $arrayWrapper->isAssociativeArray()) {
            return true;
        }

        if ($arrayWrapper->getItemCount() === 1 && ! $arrayWrapper->isFirstItemArray()) {
            $previousTokenPosition = $tokens->getPrevMeaningfulToken($blockInfo->getStart());
            if ($previousTokenPosition === null) {
                return false;
            }

            /** @var Token $previousToken */
            $previousToken = $tokens[$previousTokenPosition];
            return ! $previousToken->isGivenKind(T_DOUBLE_ARROW);
        }

        return false;
    }
}
