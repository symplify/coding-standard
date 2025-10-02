<?php

namespace Symplify\CodingStandard\Tests\Fixer\Spacing\StandaloneLinePromotedPropertyFixer\Fixture;

final class SkipAttributes
{
    public function __construct(#[JMS\Expose, JMS\Type('integer')] private int $id, private string $name) {}
}

final class SkipAttributes2
{
    public function __construct(
        #[JMS\Expose, JMS\Type('integer')]
        private int $id,
        private string $name,
    ) {}
}

final class SkipAttributes3
{
    public function __construct(
        #[JMS\Expose, JMS\Type('integer')] private int $id,
        private string $name,
    ) {}
}

final class SkipAttributes4
{
    public function __construct(
        #[JMS\Expose]
        #[JMS\Type('integer')] private int $id,
        private string $name,
    ) {}
}

final class SkipAttributes5
{
    public function __construct(
        #[JMS\Expose]
        #[JMS\Type('integer')]
        private int $id,
        private string $name,
    ) {}
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Spacing\StandaloneLinePromotedPropertyFixer\Fixture;

final class SkipAttributes
{
    public function __construct(
        #[JMS\Expose, JMS\Type('integer')] private int $id,
        private string $name
    ) {}
}

final class SkipAttributes2
{
    public function __construct(
        #[JMS\Expose, JMS\Type('integer')]
        private int $id,
        private string $name,
    ) {}
}

final class SkipAttributes3
{
    public function __construct(
        #[JMS\Expose, JMS\Type('integer')] private int $id,
        private string $name,
    ) {}
}

final class SkipAttributes4
{
    public function __construct(
        #[JMS\Expose]
        #[JMS\Type('integer')] private int $id,
        private string $name,
    ) {}
}

final class SkipAttributes5
{
    public function __construct(
        #[JMS\Expose]
        #[JMS\Type('integer')]
        private int $id,
        private string $name,
    ) {}
}

?>
