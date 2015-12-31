<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symplify\CodingStandard\Contract\Runner\RunnerInterface;
use Symfony\Component\Process\Process;

final class SymplifyRunner implements RunnerInterface
{
    /**
     * {@inheritdoc}
     */
    public function runForDirectory($directory)
    {
        $process = new Process(
            sprintf(
                'php vendor/bin/phpcs %s --standard=%s -p -s --colors --extensions=php',
                $directory,
                $this->getRuleset()
            )
        );
        $process->run();

        return $process->getOutput();
    }

    /**
     * @return string
     */
    private function getRuleset()
    {
        if (file_exists($path = 'src/SymplifyCodingStandard/ruleset.xml')) {
            return $path;
        }
        return 'vendor/symplify/coding-standard/src/SymplifyCodingStandard/ruleset.xml';
    }
}
