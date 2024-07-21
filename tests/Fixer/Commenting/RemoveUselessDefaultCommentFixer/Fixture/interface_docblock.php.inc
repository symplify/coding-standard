<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

/**
 * Interface SomeInterface
 */
interface SomeInterface
{
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

/**
 */
interface SomeInterface
{
}

?>
