<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveMethodNameDuplicateDescriptionFixer\Fixture;

final class WithReturnDateTime
{
    /**
     * Get now
     *
     * @return \DateTime
     */
    public function getNow()
    {
    }
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveMethodNameDuplicateDescriptionFixer\Fixture;

final class WithReturnDateTime
{
    /**
     *
     * @return \DateTime
     */
    public function getNow()
    {
    }
}

?>
