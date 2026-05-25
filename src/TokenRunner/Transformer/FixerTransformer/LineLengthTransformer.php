<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\TokenRunner\Transformer\FixerTransformer;

use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\CodingStandard\TokenRunner\Enum\LineKind;
use Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo;

final readonly class LineLengthTransformer
{
    public function __construct(
        private LineLengthResolver $lineLengthResolver,
        private TokensInliner $tokensInliner,
        private FirstLineLengthResolver $firstLineLengthResolver,
        private TokensNewliner $tokensNewliner
    ) {
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function fixStartPositionToEndPosition(
        BlockInfo $blockInfo,
        Tokens $tokens,
        int $lineLength,
        bool $breakLongLines,
        bool $inlineShortLine
    ): void {
        $firstLineLength = $this->firstLineLengthResolver->resolveFromTokensAndStartPosition($tokens, $blockInfo);
        if ($firstLineLength > $lineLength && $breakLongLines) {
            $this->tokensNewliner->breakItems($blockInfo, $tokens, LineKind::CALLS);
            return;
        }

        $fullLineLength = $this->lineLengthResolver->getLengthFromStartEnd($tokens, $blockInfo);
        if ($fullLineLength > $lineLength) {
            return;
        }

        if (! $inlineShortLine) {
            return;
        }

        $this->tokensInliner->inlineItems($tokens, $blockInfo);
    }
}
