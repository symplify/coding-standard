<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symfony\Component\Process\ProcessBuilder;
use Symplify\CodingStandard\Contract\Runner\RunnerInterface;

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
        $builder = (new ProcessBuilder())
            ->setPrefix('./vendor/bin/php-cs-fixer')
            ->add('fix')
            ->add($directory)
            ->add('--level=symfony')
            ->add('--fixers=-phpdoc_params')
            ->add('--dry-run')
            ->add('--diff');

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
        $builder = (new ProcessBuilder())
            ->setPrefix('./vendor/bin/php-cs-fixer')
            ->add('fix')
            ->add($directory)
            ->add('--level=symfony')
            ->add('--fixers=-phpdoc_params');

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
