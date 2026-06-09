<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\TokenRunner\DocBlock\MalformWorker;

use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\CodingStandard\TokenRunner\Contract\DocBlock\MalformWorkerInterface;
use Symplify\CodingStandard\Utils\Regex;

final class ParamNameReferenceMalformWorker implements MalformWorkerInterface
{
    /**
     * @see https://regex101.com/r/B4rWNk/3
     */
    private const string PARAM_NAME_REGEX = '#(?<param>@param(.*?))&(?<paramName>\$\w+)#';

    /**
     * @param Tokens<Token> $tokens
     */
    public function work(string $docContent, Tokens $tokens, int $position): string
    {
        return Regex::replace(
            $docContent,
            self::PARAM_NAME_REGEX,
            static fn ($match): string => $match['param'] . $match['paramName']
        );
    }
}
