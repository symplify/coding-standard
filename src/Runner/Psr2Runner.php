<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symfony\Component\Process\Process;
use Symplify\CodingStandard\Contract\Runner\FixableRunnerInterface;

final class Psr2Runner implements FixableRunnerInterface
{
    /**
     * @var string
     */
    private $output;

    /**
     * @var string
     */
    private $extensions;

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
        $process = new Process(
            sprintf(
                'php vendor/bin/phpcs %s --standard=PSR2 -p -s --colors --extensions=%s',
                $directory,
                $this->extensions
            )
        );
        $process->run();

        $this->output = $process->getOutput();

        return $this->output;
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

    /**
     * {@inheritdoc}
     */
    public function fixDirectory($directory)
    {
        $process = new Process(
            sprintf(
                'php vendor/bin/phpbf %s --standard=PSR2 --extensions=%s',
                $directory,
                $this->extensions
            )
        );
        $process->run();
    }
}
