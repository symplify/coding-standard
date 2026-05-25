<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Tests\Fixer\LineLength\LineLengthFixer\Fixture;

final class InlinePrivatePropertyPromotionIssue74
{
    public function __construct(
        private \stdClass $foo,
    ) {
    }
}

?>
-----
<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Tests\Fixer\LineLength\LineLengthFixer\Fixture;

final class InlinePrivatePropertyPromotionIssue74
{
    public function __construct(private \stdClass $foo,) {
    }
}

?>
