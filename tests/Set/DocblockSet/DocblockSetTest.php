<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Tests\Set\DocblockSet;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symplify\EasyCodingStandard\Testing\PHPUnit\AbstractCheckerTestCase;

/**
 * Integration test verifying the docblock set rules work together on real-world malformed doc blocks.
 */
final class DocblockSetTest extends AbstractCheckerTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFiles(__DIR__ . '/Fixture');
    }

    public function provideConfig(): string
    {
        return __DIR__ . '/../../../config/sets/docblock.php';
    }
}
