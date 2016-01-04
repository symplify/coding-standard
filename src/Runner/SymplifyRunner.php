<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symfony\Component\Process\ProcessBuilder;
use Symplify\CodingStandard\Contract\Runner\RunnerInterface;

final class SymplifyRunner implements RunnerInterface
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
        $builder = (new ProcessBuilder())
            ->setPrefix('./vendor/bin/phpcs')
            ->add($directory)
            ->add('--standard='.$this->getRuleset())
            ->add('--extensions='.$this->extensions)
            ->add('--colors')
            ->add('-p')
            ->add('-s');

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
            ->setPrefix('./vendor/bin/phpcbf')
            ->add($directory)
            ->add('--standard='.$this->getRuleset())
            ->add('--extensions='.$this->extensions);

        $process = $builder->getProcess();
        $process->run();

        return $process->getOutput();
    }

    /**
     * @param string $output
     */
    private function detectErrorsInOutput($output)
    {
        if (strpos($output, 'ERROR') !== false) {
            $this->hasErrors = true;
        }
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
