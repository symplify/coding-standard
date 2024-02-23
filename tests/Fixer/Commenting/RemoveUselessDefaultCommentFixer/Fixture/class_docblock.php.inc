<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

/**
 * class SomeClass
 */
class SomeClass1
{
}

/**
 * Class SomeClass
 */
class SomeClass2
{
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;


class SomeClass1
{
}


class SomeClass2
{
}

?>
