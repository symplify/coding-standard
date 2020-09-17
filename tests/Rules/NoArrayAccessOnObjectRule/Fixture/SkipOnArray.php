<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Tests\Rules\NoArrayAccessOnObjectRule\Fixture;

final class SkipOnArray
{
    public function run(array $values)
    {
        return $values['key'];
    }
}
