<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Tests\Fixer\Annotation\DoctrineAnnotationNewlineInNestedAnnotationFixer;

use Iterator;
use Symplify\CodingStandard\Fixer\Annotation\DoctrineAnnotationNewlineInNestedAnnotationFixer;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class DoctrineAnnotationNewlineInNestedAnnotationFixerTest extends AbstractCheckerTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fileInfo): void
    {
        $this->doTestFileInfo($fileInfo);
    }

    /**
     * @return Iterator<mixed, SmartFileInfo>
     */
    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectoryExclusively(__DIR__ . '/Fixture');
    }

    protected function getCheckerClass(): string
    {
        return DoctrineAnnotationNewlineInNestedAnnotationFixer::class;
    }
}
