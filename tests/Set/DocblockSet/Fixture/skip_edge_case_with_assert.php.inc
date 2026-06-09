<?php

namespace Symplify\CodingStandard\Tests\Set\DocblockSet\Fixture;

use PHPUnit\Framework\TestCase;

final class SkipEdgeCaseWithAssert extends TestCase
{
    public function testThat()
    {
        /** @var ErrorResource $response */
        $this->assertEquals('....', $response->getResponse()['message']);
    }
}
