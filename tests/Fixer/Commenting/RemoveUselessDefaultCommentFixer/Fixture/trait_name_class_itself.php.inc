<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

/**
 * useful comment here
 *
 * ThisIsOnlyTrait
 */
trait ThisIsOnlyTrait
{
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

/**
 * useful comment here
 *
 */
trait ThisIsOnlyTrait
{
}

?>
