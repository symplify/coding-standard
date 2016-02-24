<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Process;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Symplify\CodingStandard\Contract\Process\ProcessBuilderInterface;

final class PhpCsFixerProcessBuilder implements ProcessBuilderInterface
{
    /**
     * @var ProcessBuilder
     */
    private $builder;

    /**
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->builder = new ProcessBuilder();
        $this->builder->setPrefix('./vendor/bin/php-cs-fixer');
        $this->builder->add('fix');
        $this->builder->add($directory);
    }

    /**
     * {@inheritdoc}
     */
    public function getProcess()
    {
        return $this->builder->getProcess();
    }

    /**
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->builder->add('--level='.$level);
    }

    /**
     * @param string $fixers
     */
    public function setFixers($fixers)
    {
        $this->builder->add('--fixers='.$fixers);
    }

    public function enableDryRun()
    {
        $this->builder->add('--dry-run');
        $this->builder->add('--diff');
    }
}
