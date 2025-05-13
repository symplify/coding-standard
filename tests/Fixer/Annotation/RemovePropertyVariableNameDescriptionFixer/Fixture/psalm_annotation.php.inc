<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemovePropertyVariableNameDescriptionFixer\Fixture;

final class PsalmAnnotation
{
    /**
     * @psalm-var string $name
     */
    public $name;
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemovePropertyVariableNameDescriptionFixer\Fixture;

final class PsalmAnnotation
{
    /**
     * @psalm-var string
     */
    public $name;
}

?>
