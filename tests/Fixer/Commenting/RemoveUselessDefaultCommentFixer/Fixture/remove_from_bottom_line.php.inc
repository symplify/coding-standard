<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

/**
 * @property SomeItem $item
 * Class RemoveFromPropertyTest
 */
#[\AllowDynamicProperties]
final class RemoveFromBottomLine
{
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

/**
 * @property SomeItem $item
 */
#[\AllowDynamicProperties]
final class RemoveFromBottomLine
{
}

?>
