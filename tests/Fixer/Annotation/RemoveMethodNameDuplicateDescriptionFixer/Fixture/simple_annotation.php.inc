<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveMethodNameDuplicateDescriptionFixer\Fixture;

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

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveMethodNameDuplicateDescriptionFixer\Fixture;

final class SimpleAnnotation
{
    /**
     */
    public function setName()
    {
    }
}

?>
