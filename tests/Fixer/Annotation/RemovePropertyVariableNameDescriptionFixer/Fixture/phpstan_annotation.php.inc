<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemovePropertyVariableNameDescriptionFixer\Fixture;

final class PhpstanAnnotation
{
    /**
     * @phpstan-var string $name
     */
    public $name;
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemovePropertyVariableNameDescriptionFixer\Fixture;

final class PhpstanAnnotation
{
    /**
     * @phpstan-var string
     */
    public $name;
}

?>
