<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symplify\CodingStandard\Command\CheckCommand;
use Symplify\CodingStandard\Command\FixCommand;
use Symplify\CodingStandard\Runner\Psr2Runner;
use Symplify\CodingStandard\Runner\RunnerCollection;
use Symplify\CodingStandard\Runner\SymfonyRunner;
use Symplify\CodingStandard\Runner\SymplifyRunner;

final class Application extends BaseApplication
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('Symplify Coding Standard', null);

        $runnerCollection = new RunnerCollection();
        $runnerCollection->addRunner(new SymplifyRunner());
        $runnerCollection->addRunner(new Psr2Runner());
        $runnerCollection->addRunner(new SymfonyRunner());

        $this->add(new CheckCommand($runnerCollection));
        $this->add(new FixCommand($runnerCollection));
    }
}
