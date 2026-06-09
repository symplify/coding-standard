<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Symplify\CodingStandard\Utils\Regex;

final class RegexTest extends TestCase
{
    public function testMatchReturnsNamedGroups(): void
    {
        $match = Regex::match('@param string $value', '#@param\s+(?<type>\w+)\s+\$(?<name>\w+)#');

        $this->assertNotNull($match);
        $this->assertSame('string', $match['type']);
        $this->assertSame('value', $match['name']);
    }

    public function testMatchReturnsNullOnNoMatch(): void
    {
        $this->assertNull(Regex::match('nothing here', '#@param#'));
    }

    public function testMatchAllReturnsSetOrder(): void
    {
        $matches = Regex::matchAll('$a $b $c', '#\$(?<name>\w)#');

        $this->assertCount(3, $matches);
        $this->assertSame('a', $matches[0]['name']);
        $this->assertSame('c', $matches[2]['name']);
    }

    public function testReplaceWithString(): void
    {
        $this->assertSame('x-x', Regex::replace('1-2', '#\d#', 'x'));
    }

    public function testReplaceWithDefaultRemovesMatch(): void
    {
        $this->assertSame('abc', Regex::replace('a1b2c3', '#\d#'));
    }

    public function testReplaceWithCallable(): void
    {
        $result = Regex::replace('a1b', '#\d#', static fn (array $match): string => '[' . $match[0] . ']');

        $this->assertSame('a[1]b', $result);
    }
}
