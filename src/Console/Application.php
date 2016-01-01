<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symplify\CodingStandard\Command\CheckCommand;
use Symplify\CodingStandard\Runner\Psr2Runner;
use Symplify\CodingStandard\Runner\SymfonyRunner;
use Symplify\CodingStandard\Runner\SymplifyRunner;

final class Application extends BaseApplication
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        error_reporting(-1);

        parent::__construct('Symplify Coding Standard', null);

        $checkCommand = new CheckCommand();
        $checkCommand->addRunner(new SymplifyRunner());
        $checkCommand->addRunner(new Psr2Runner());
        $checkCommand->addRunner(new SymfonyRunner());

        $this->add($checkCommand);

        $this->setDefaultCommand('check');
    }
}
