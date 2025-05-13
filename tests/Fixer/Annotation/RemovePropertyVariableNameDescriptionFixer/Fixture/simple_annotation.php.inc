<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemovePropertyVariableNameDescriptionFixer\Fixture;

final class SimpleAnnotation
{
    /**
     * @var string $name
     */
    public $name;
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemovePropertyVariableNameDescriptionFixer\Fixture;

final class SimpleAnnotation
{
    /**
     * @var string
     */
    public $name;
}

?>
