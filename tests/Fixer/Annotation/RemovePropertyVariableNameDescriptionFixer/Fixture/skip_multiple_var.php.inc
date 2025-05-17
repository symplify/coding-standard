<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemovePropertyVariableNameDescriptionFixer\Fixture;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;

final class SkipMultipleVar
{
    public function run()
    {
        /**
         * @var FuncCall $firstArgumentValue
         * @var array<Arg> $args
         **/
        $args = $firstArgumentValue->getArgs();
    }
}
