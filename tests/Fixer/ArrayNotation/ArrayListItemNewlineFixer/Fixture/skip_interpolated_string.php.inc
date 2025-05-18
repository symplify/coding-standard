<?php

namespace Symplify\CodingStandard\Tests\Fixer\ArrayNotation\ArrayListItemNewlineFixer\Fixture;

final class SkipInterpolatedString
{
    public function run()
    {
        $a = 'A';
        $b = 'B';

        return [
            'text' => "{$a},{$b}",
        ];
    }
}
