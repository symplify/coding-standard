<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symplify\CodingStandard\Contract\Runner\RunnerInterface;
use Symplify\CodingStandard\Process\PhpCsFixerProcessBuilder;

final class SymfonyRunner implements RunnerInterface
{
    /**
     * @var bool
     */
    private $hasErrors = false;

    /**
     * {@inheritdoc}
     */
    public function runForDirectory($directory)
    {
        $builder = new PhpCsFixerProcessBuilder($directory);
        $builder->setLevel('symfony');
        $builder->setFixers('-phpdoc_params');
        $builder->enableDryRun();

        $process = $builder->getProcess();
        $process->run();

        $this->detectErrorsInOutput($process->getOutput());

        return $process->getOutput();
    }

    /**
     * {@inheritdoc}
     */
    public function hasErrors()
    {
        return $this->hasErrors;
    }

    /**
     * {@inheritdoc}
     */
    public function fixDirectory($directory)
    {
        $builder = new PhpCsFixerProcessBuilder($directory);
        $builder->setLevel('symfony');
        $builder->setFixers('-phpdoc_params');

        $process = $builder->getProcess();
        $process->run();

        return $process->getOutput();
    }

    /**
     * @param string $output
     */
    private function detectErrorsInOutput($output)
    {
        if (strpos($output, 'end diff') !== false) {
            $this->hasErrors = true;
        }
    }
}
