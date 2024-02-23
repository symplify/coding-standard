<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

/**
 * Class RemoveFromPropertyTest
 * @property SomeItem $item
 */
#[\AllowDynamicProperties]
final class RemoveFromPropertyTest
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
final class RemoveFromPropertyTest
{
}

?>
