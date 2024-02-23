<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

final class SkipNoChanges
{
    public function run()
    {
        // some line
        $someLine = 100;

        // another line
        $someLine = 100;
    }
}
