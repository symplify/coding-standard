<?php declare(strict_types=1);

namespace Symplify\CodingStandard\Fixer\LineLength;

use PhpCsFixer\Fixer\DefinedFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\WhitespacesFixerConfig;
use SplFileInfo;
use Symplify\TokenRunner\Analyzer\FixerAnalyzer\IndentDetector;
use Symplify\TokenRunner\Configuration\Configuration;
use Symplify\TokenRunner\Transformer\FixerTransformer\LineLengthTransformer;
use Symplify\TokenRunner\Wrapper\FixerWrapper\MethodWrapper;
use Symplify\TokenRunner\Wrapper\FixerWrapper\MethodWrapperFactory;

final class BreakMethodArgumentsFixer implements DefinedFixerInterface
{
    /**
     * @var WhitespacesFixerConfig
     */
    private $whitespacesFixerConfig;

    /**
     * @var IndentDetector
     */
    private $indentDetector;

    /**
     * @var string
     */
    private $indentWhitespace;

    /**
     * @var string
     */
    private $newlineIndentWhitespace;

    /**
     * @var string
     */
    private $closingBracketNewlineIndentWhitespace;

    /**
     * @var MethodWrapperFactory
     */
    private $methodWrapperFactory;

    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var LineLengthTransformer
     */
    private $lineLengthTransformer;

    public function __construct(
        Configuration $configuration,
        WhitespacesFixerConfig $whitespacesFixerConfig,
        MethodWrapperFactory $methodWrapperFactory,
        IndentDetector $indentDetector,
        LineLengthTransformer $lineLengthTransformer
    ) {
        $this->methodWrapperFactory = $methodWrapperFactory;
        $this->indentDetector = $indentDetector;
        $this->configuration = $configuration;
        $this->whitespacesFixerConfig = $whitespacesFixerConfig;
        $this->lineLengthTransformer = $lineLengthTransformer;
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition('Arguments should be on the same/standalone line to fit line length.', [
            new CodeSample(
                '<?php
class SomeClass
{
    public function someMethod(SuperLongArguments $superLongArguments, AnotherLongArguments $anotherLongArguments)
    {
    }

    public function anotherMethod(
        ShortArgument $shortArgument,
        AnotherShortArgument $anotherShortArgument
    ) {
    }
}'
            ),
        ]);
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAllTokenKindsFound([T_FUNCTION, ',']);
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        /** @var Token[] $reversedTokens */
        $reversedTokens = array_reverse($tokens->toArray(), true);

        foreach ($reversedTokens as $position => $token) {
            if (! $token->isGivenKind(T_FUNCTION)) {
                continue;
            }

            $this->fixMethod($position, $tokens);
        }
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return self::class;
    }

    public function getPriority(): int
    {
        return 0;
    }

    public function supports(SplFileInfo $file): bool
    {
        return true;
    }

    private function fixMethod(int $position, Tokens $tokens): void
    {
        $methodWrapper = $this->methodWrapperFactory->createFromTokensAndPosition($tokens, $position);
        if (! $methodWrapper->getArguments()) {
            return;
        }

        $blockStart =  $methodWrapper->getArgumentsBracketStart();
        $blockEnd = $methodWrapper->getArgumentsBracketEnd();

        if ($methodWrapper->getFirstLineLength() > $this->configuration->getMaxLineLength()) {
            $this->breakMethodArguments($blockStart, $blockEnd, $tokens, $position);
            return;
        }

        if ($methodWrapper->getLineLengthToEndOfArguments() <= $this->configuration->getMaxLineLength()) {
            $this->inlineMethodArguments($blockEnd, $tokens, $position);
            return;
        }
    }

    private function prepareIndentWhitespaces(Tokens $tokens, int $arrayStartIndex): void
    {
        $indentLevel = $this->indentDetector->detectOnPosition(
            $tokens,
            $arrayStartIndex,
            $this->whitespacesFixerConfig
        );
        $indentWhitespace = $this->whitespacesFixerConfig->getIndent();
        $lineEnding = $this->whitespacesFixerConfig->getLineEnding();

        $this->indentWhitespace = str_repeat($indentWhitespace, $indentLevel + 1);
        $this->closingBracketNewlineIndentWhitespace = $lineEnding . str_repeat($indentWhitespace, $indentLevel);
        $this->newlineIndentWhitespace = $lineEnding . $this->indentWhitespace;
    }

    private function breakMethodArguments(int $start, int $end, Tokens $tokens, int $position): void
    {
        $this->prepareIndentWhitespaces($tokens, $position);

        // 1. break after arguments opening
        $tokens->ensureWhitespaceAtIndex($start + 1, 0, $this->newlineIndentWhitespace);

        // 2. break before arguments closing
        $tokens->ensureWhitespaceAtIndex($end + 1, 0, $this->closingBracketNewlineIndentWhitespace);

        for ($i = $start; $i < $end; ++$i) {
            $currentToken = $tokens[$i];

            // 3. new line after each comma ",", instead of just space
            if ($currentToken->getContent() === ',') {
                $tokens->ensureWhitespaceAtIndex($i + 1, 0, $this->newlineIndentWhitespace);
            }
        }
    }

    private function inlineMethodArguments(int $endPosition, Tokens $tokens, int $position): void
    {
        // replace PHP_EOL with " "
        for ($i = $position; $i < $endPosition; ++$i) {
            $currentToken = $tokens[$i];

            if (! $currentToken->isGivenKind(T_WHITESPACE)) {
                continue;
            }

            $previousToken = $tokens[$i - 1];
            $nextToken = $tokens[$i + 1];
            if ($previousToken->getContent() === '(' || $nextToken->getContent() === ')') {
                $tokens->clearAt($i);
                continue;
            }

            $tokens[$i] = new Token([T_WHITESPACE, ' ']);
        }
    }
}
