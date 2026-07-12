<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveMethodNameDuplicateDescriptionFixer\Fixture;

final class WithArticles
{
    /**
     * Get the API helper.
     *
     * @return object
     */
    public function getApiHelper()
    {
    }
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\RemoveMethodNameDuplicateDescriptionFixer\Fixture;

final class WithArticles
{
    /**
     *
     * @return object
     */
    public function getApiHelper()
    {
    }
}

?>
