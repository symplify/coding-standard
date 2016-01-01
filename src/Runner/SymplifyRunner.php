<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symfony\Component\Process\Process;
use Symplify\CodingStandard\Contract\Runner\RunnerInterface;

final class SymplifyRunner implements RunnerInterface
{
    /**
     * @var string
     */
    private $output;

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

        $this->output = $process->getOutput();

        return $this->output;
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

    /**
     * {@inheritdoc}
     */
    public function hasErrors()
    {
        if (strpos($this->output, 'ERROR') !== false) {
            return true;
        }

        return false;
    }
}
