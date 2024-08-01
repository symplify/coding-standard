<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

final class ConstructorBlank
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

final class ConstructorBlank
{
    public function __construct()
    {
    }
}

?>
