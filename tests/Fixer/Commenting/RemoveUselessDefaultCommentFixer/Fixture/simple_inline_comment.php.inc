<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;

// class SomeClass
class SomeClass4
{
}

// class        SomeClass
class SomeClass5
{
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Commenting\RemoveUselessDefaultCommentFixer\Fixture;


class SomeClass4
{
}


class SomeClass5
{
}

?>
