<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symplify\CodingStandard\Contract\Runner\RunnerInterface;
use Symplify\CodingStandard\Process\PhpCbfProcessBuilder;
use Symplify\CodingStandard\Process\PhpCsProcessBuilder;

final class Psr2Runner implements RunnerInterface
{
    /**
     * @var string
     */
    private $extensions;

    /**
     * @var bool
     */
    private $hasErrors = false;

    /**
     * @param string $extensions
     */
    public function __construct($extensions = 'php')
    {
        $this->extensions = $extensions;
    }

    /**
     * {@inheritdoc}
     */
    public function runForDirectory($directory)
    {
        $builder = new PhpCsProcessBuilder($directory);
        $builder->setExtensions($this->extensions);
        $builder->setStandard('psr2');

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
        $builder = new PhpCbfProcessBuilder($directory);
        $builder->setStandard('psr2');
        $builder->setExtensions($this->extensions);

        $process = $builder->getProcess();
        $process->run();

        return $process->getOutput();
    }

    /**
     * @param $output
     */
    private function detectErrorsInOutput($output)
    {
        if (strpos($output, 'ERROR') !== false) {
            $this->hasErrors = true;
        }
    }
}
