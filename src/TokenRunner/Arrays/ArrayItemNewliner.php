<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\TokenRunner\Arrays;

use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;
use Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\ArrayAnalyzer;
use Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo;

final readonly class ArrayItemNewliner
{
    public function __construct(
        private ArrayAnalyzer $arrayAnalyzer,
        private WhitespacesFixerConfig $whitespacesFixerConfig
    ) {
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function fixArrayOpener(Tokens $tokens, BlockInfo $blockInfo): void
    {
        $this->arrayAnalyzer->traverseArrayWithoutNesting(
            $tokens,
            $blockInfo,
            function (Token $token, int $position, Tokens $tokens): void {
                if ($token->getContent() !== ',') {
                    return;
                }

                $nextTokenPosition = $position + 1;
                $nextToken = $tokens[$nextTokenPosition] ?? null;
                if (! $nextToken instanceof Token) {
                    return;
                }

                if (\str_contains($nextToken->getContent(), "\n")) {
                    return;
                }

                $lookaheadPosition = $tokens->getNonWhitespaceSibling($position, 1, " \t\r\0\x0B");
                if ($lookaheadPosition !== null && $tokens[$lookaheadPosition]->isGivenKind(T_COMMENT)) {
                    return;
                }

                $tokens->ensureWhitespaceAtIndex($nextTokenPosition, 0, $this->whitespacesFixerConfig->getLineEnding());
            }
        );
    }
}
