<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveSetterGetterDocblockFixer\Fixture;

final class SimpleAnnotation
{
    /**
     * Set name
     */
    public function setName()
    {
    }
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveSetterGetterDocblockFixer\Fixture;

final class SimpleAnnotation
{
    /**
     */
    public function setName()
    {
    }
}

?>
