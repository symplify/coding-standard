<?php

namespace Symplify\CodingStandard\Tests\Fixer\ArrayNotation\DataProviderArrayNewlineFixer\Fixture;

use PHPUnit\Framework\TestCase;

final class BareList extends TestCase
{
    public function provideData()
    {
        return ['simple', 'easy'];
    }
}

?>
-----
<?php

namespace Symplify\CodingStandard\Tests\Fixer\ArrayNotation\DataProviderArrayNewlineFixer\Fixture;

use PHPUnit\Framework\TestCase;

final class BareList extends TestCase
{
    public function provideData()
    {
        return [
            'simple',
            'easy'
        ];
    }
}

?>
