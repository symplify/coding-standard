<?php

declare (strict_types = 1);

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Process;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Symplify\CodingStandard\Contract\Process\ProcessBuilderInterface;

final class PhpCsProcessBuilder implements ProcessBuilderInterface
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
        $this->builder->setPrefix('./vendor/bin/phpcs');
        $this->builder->add($directory);
        $this->builder->add('--colors');
        $this->builder->add('-p');
        $this->builder->add('-s');
    }

    /**
     * {@inheritdoc}
     */
    public function getProcess()
    {
        return $this->builder->getProcess();
    }

    /**
     * @param string $standard
     */
    public function setStandard($standard)
    {
        $this->builder->add('--standard='.$standard);
    }

    /**
     * @param string $extensions
     */
    public function setExtensions($extensions)
    {
        $this->builder->add('--extensions='.$extensions);
    }
}
