<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Tests;

use Iterator;

final class DataProviderFixtureYielder
{
    public static function yieldDirectory(string $directory): Iterator
    {
        /** @var string[] $filePaths */
        $filePaths = glob($directory . '/*');

        foreach ($filePaths as $filePath) {
            yield [$filePath];
        }
    }
}
