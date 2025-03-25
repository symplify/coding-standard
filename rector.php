<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/tests'])
    ->withPhpSets()
    ->withRootFiles()
    ->withPreparedSets(codeQuality: true, codingStyle: true, naming: true, earlyReturn: true, privatization: true)
    ->withImportNames(removeUnusedImports: true)
    ->withSkip([
        '*/Source/*',
        '*/Fixture/*',
    ]);
