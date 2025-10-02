<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/tests'])
    ->withRootFiles()
    ->withPhpSets()
    ->withPreparedSets(codeQuality: true, codingStyle: true, privatization: true, naming: true, earlyReturn: true)
    ->withImportNames()
    ->withSkip([
        '*/Source/*',
        '*/Fixture/*',
    ]);
