<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symplify\CodingStandard\Contract\Runner\RunnerInterface;
use Symfony\Component\Process\Process;

final class Psr2Runner implements RunnerInterface
{
    /**
     * {@inheritdoc}
     */
    public function runForDirectory($directory)
    {
        $process = new Process(
            sprintf(
                'php vendor/bin/phpcs %s --standard=PSR2 -p -s --colors --extensions=php',
                $directory
            )
        );
        $process->run();

        return $process->getOutput();
    }
}
