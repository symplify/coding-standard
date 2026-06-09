<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Fixer\Commenting;

use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\CodingStandard\Utils\Regex;

/**
 * @see \Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveSuperfluousReturnNameFixer\RemoveSuperfluousReturnNameFixerTest
 */
final class RemoveSuperfluousReturnNameFixer extends AbstractDocBlockFixer
{
    private const string ERROR_MESSAGE = 'Remove a superfluous variable name from a @return annotation';

    /**
     * @see https://regex101.com/r/4qyd2j/1
     */
    private const string RETURN_VARIABLE_NAME_REGEX = '#(?<tag>@(?:psalm-|phpstan-)?return)(?<type>\s+[|\\\\\w]+)?(\s+)(?<' . self::VARIABLE_NAME_PART . '>\$[\w]+)#';

    /**
     * @var string[]
     */
    private const array ALLOWED_VARIABLE_NAMES = ['$this'];

    /**
     * @see https://regex101.com/r/IE9fA6/1
     */
    private const string VARIABLE_NAME_REGEX = '#\$\w+#';

    private const string VARIABLE_NAME_PART = 'variableName';

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }

    /**
     * @param Tokens<Token> $tokens
     */
    protected function processDocContent(string $docContent, Tokens $tokens, int $position): string
    {
        $docBlock = new DocBlock($docContent);

        $lines = $docBlock->getLines();
        foreach ($lines as $line) {
            $match = Regex::match($line->getContent(), self::RETURN_VARIABLE_NAME_REGEX);
            if ($match === null) {
                continue;
            }

            if ($this->shouldSkip($match, $line->getContent())) {
                continue;
            }

            $newLineContent = Regex::replace(
                $line->getContent(),
                self::RETURN_VARIABLE_NAME_REGEX,
                static function (array $match) {
                    $replacement = $match['tag'];
                    if ($match['type'] !== []) {
                        $replacement .= $match['type'];
                    }

                    return $replacement;
                }
            );

            $line->setContent($newLineContent);
        }

        return $docBlock->getContent();
    }

    /**
     * @param array<string, string> $match
     */
    private function shouldSkip(array $match, string $content): bool
    {
        if (in_array($match[self::VARIABLE_NAME_PART], self::ALLOWED_VARIABLE_NAMES, true)) {
            return true;
        }

        // has multiple return values? "@return array $one, $two"
        return count(Regex::matchAll($content, self::VARIABLE_NAME_REGEX)) >= 2;
    }
}
