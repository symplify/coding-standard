<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Process;

use Symfony\Component\Process\ProcessBuilder;
use Symplify\CodingStandard\Contract\Process\ProcessBuilderInterface;

final class PhpCbfProcessBuilder implements ProcessBuilderInterface
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
        $this->builder->setPrefix('./vendor/bin/phpcbf');
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
