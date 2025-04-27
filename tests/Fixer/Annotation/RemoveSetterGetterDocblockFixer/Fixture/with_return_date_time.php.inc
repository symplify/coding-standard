<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveSetterGetterDocblockFixer\Fixture;

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

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveSetterGetterDocblockFixer\Fixture;

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
