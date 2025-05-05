<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Fixer\Annotation;

use Nette\Utils\Strings;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;
use Symplify\CodingStandard\Fixer\Naming\MethodNameResolver;
use Symplify\CodingStandard\TokenRunner\Traverser\TokenReverser;

/**
 * @see \Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveRedundantDescriptionFixer\RemoveRedundantDescriptionFixerTest
 */
final class RemoveMethodNameDuplicateDescriptionFixer extends AbstractSymplifyFixer
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Remove docblock descriptions which duplicate their method name';

    private readonly MethodNameResolver $methodNameResolver;

    public function __construct(
        private readonly TokenReverser $tokenReverser
    ) {
        $this->methodNameResolver = new MethodNameResolver();
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
        if (! $tokens->isTokenKindFound(T_FUNCTION)) {
            return false;
        }

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

            $methodName = $this->methodNameResolver->resolve($tokens, $index);
            if (is_null($methodName)) {
                continue;
            }

            // skip if not setter or getter
            $originalDocContent = $token->getContent();

            $hasChanged = false;

            $docblockLines = explode("\n", $originalDocContent);
            foreach ($docblockLines as $key => $docblockLine) {
                $spacelessDocblockLine = Strings::replace($docblockLine, '#[\s\n]+#', '');
                if (strtolower($spacelessDocblockLine) !== strtolower('*' . $methodName)) {
                    continue;
                }

                $hasChanged = true;
                unset($docblockLines[$key]);
            }

            if (! $hasChanged) {
                continue;
            }

            $tokens[$index] = new Token([T_DOC_COMMENT, implode("\n", $docblockLines)]);
        }
    }
}
