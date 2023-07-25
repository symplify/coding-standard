<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Fixer\Commenting;

use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\CodingStandard\DocBlock\UselessDocBlockCleaner;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;
use Symplify\CodingStandard\TokenRunner\Traverser\TokenReverser;

/**
 * @see \Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\RemoveUselessDefaultCommentFixerTest
 */
final class RemoveUselessDefaultCommentFixer extends AbstractSymplifyFixer
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Remove useless PHPStorm-generated @todo comments, redundant "Class XY" or "gets service" comments etc.';

    public function __construct(
        private readonly UselessDocBlockCleaner $uselessDocBlockCleaner,
        private readonly TokenReverser $tokenReverser
    ) {
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAnyTokenKindsFound([T_DOC_COMMENT, T_COMMENT]);
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function fix(SplFileInfo $fileInfo, Tokens $tokens): void
    {
        $reversedTokens = $this->tokenReverser->reverse($tokens);

        foreach ($reversedTokens as $index => $token) {
            if (! $token->isGivenKind([T_DOC_COMMENT, T_COMMENT])) {
                continue;
            }

            $cleanedDocContent = $this->uselessDocBlockCleaner->clearDocTokenContent(
                $reversedTokens,
                $index,
                $token->getContent()
            );
            if ($cleanedDocContent !== '') {
                continue;
            }

            // remove token
            $tokens->clearAt($index);
        }
    }
}
