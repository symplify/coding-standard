<?php

namespace Symplify\CodingStandard\Tests\Fixer\Spacing\StandaloneLinePromotedPropertyFixer\Fixture;

final class PromotedProperties
{
    public function __construct(public int $age)
    {
    }
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Spacing\StandaloneLinePromotedPropertyFixer\Fixture;

final class PromotedProperties
{
    public function __construct(
        public int $age
    )
    {
    }
}

?>
