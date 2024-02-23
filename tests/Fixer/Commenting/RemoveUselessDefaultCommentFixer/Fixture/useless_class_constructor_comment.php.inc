<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

final class UselessClassConstructorComment
{
    /**
     * SomeClass constructor.
     */
    public function __construct()
    {
    }
}

class SomeClass
{
    // SomeClass constructor
    public function __construct()
    {
    }
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

final class UselessClassConstructorComment
{
    public function __construct()
    {
    }
}

class SomeClass
{
    public function __construct()
    {
    }
}

?>
