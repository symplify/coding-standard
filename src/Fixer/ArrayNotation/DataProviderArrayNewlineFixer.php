<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Fixer\ArrayNotation;

use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;
use SplFileInfo;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;
use Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\ArrayAnalyzer;
use Symplify\CodingStandard\TokenRunner\Arrays\ArrayItemNewliner;
use Symplify\CodingStandard\TokenRunner\Traverser\ArrayBlockInfoFinder;
use Symplify\CodingStandard\TokenRunner\ValueObject\TokenKinds;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Symplify\CodingStandard\Tests\Fixer\ArrayNotation\DataProviderArrayNewlineFixer\DataProviderArrayNewlineFixerTest
 */
final class DataProviderArrayNewlineFixer extends AbstractSymplifyFixer implements DocumentedRuleInterface
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'PHP array item in data provider has to have new line per item';

    private ArrayItemNewliner $arrayItemNewliner;

    public function __construct(
        private readonly ArrayAnalyzer $arrayAnalyzer,
        private readonly WhitespacesFixerConfig $whitespacesFixerConfig,
        private readonly ArrayBlockInfoFinder $arrayBlockInfoFinder
    ) {
        // will be handled on relesae
        $this->arrayItemNewliner = new ArrayItemNewliner($this->arrayAnalyzer, $this->whitespacesFixerConfig);
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }

    public function getPriority(): int
    {
        return 40;
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function isCandidate(Tokens $tokens): bool
    {
        if (! $tokens->isTokenKindFound(T_CLASS)) {
            return false;
        }

        if (! $tokens->isTokenKindFound(T_RETURN)) {
            return false;
        }

        return $tokens->isAnyTokenKindsFound(TokenKinds::ARRAY_OPEN_TOKENS);
    }

    /**
     * @param Tokens<Token> $tokens
     */
    public function fix(SplFileInfo $fileInfo, Tokens $tokens): void
    {
        if (! $this->isInsidePHPUnitTestCase($tokens)) {
            return;
        }

        $arrayBlockInfos = $this->arrayBlockInfoFinder->findArrayOpenerBlockInfos($tokens);
        foreach ($arrayBlockInfos as $arrayBlockInfo) {
            $this->arrayItemNewliner->fixArrayOpener($tokens, $arrayBlockInfo);
        }
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(self::ERROR_MESSAGE, [
            new CodeSample(
                <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class SomeTest extends TestCase
{
    public function provideData()
    {
        return [1, 2, 3];
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class SomeTest extends TestCase
{
    public function provideData()
    {
        return [
            1,
            2,
            3
        ];
    }
}

CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @param Tokens<Token> $tokens
     */
    private function isInsidePHPUnitTestCase(Tokens $tokens): bool
    {
        // function arguments, function call parameters, lambda use()
        foreach ($tokens as $position => $token) {
            if (! $token->isGivenKind(T_EXTENDS)) {
                continue;
            }

            $parentClassNamePosition = $tokens->getNextTokenOfKind($position, [[T_STRING]], false);
            if (! is_int($parentClassNamePosition)) {
                continue;
            }

            /** @var Token $parentClassNameToken */
            $parentClassNameToken = $tokens[$parentClassNamePosition];

            // we're in a test case most likely
            if (str_ends_with($parentClassNameToken->getContent(), 'TestCase')) {
                return true;
            }
        }

        return false;
    }
}
