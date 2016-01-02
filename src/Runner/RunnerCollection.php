<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Runner;

use Symplify\CodingStandard\Contract\Runner\FixableRunnerInterface;
use Symplify\CodingStandard\Contract\Runner\RunnerCollectionInterface;
use Symplify\CodingStandard\Contract\Runner\RunnerInterface;

final class RunnerCollection implements RunnerCollectionInterface
{
    /**
     * @var RunnerInterface[]
     */
    private $runners;

    /**
     * {@inheritdoc}
     */
    public function addRunner(RunnerInterface $runner)
    {
        $this->runners[] = $runner;
    }

    /**
     * {@inheritdoc}
     */
    public function getRunners()
    {
        return $this->runners;
    }

    /**
     * {@inheritdoc}
     */
    public function getFixableRunners()
    {
        return array_filter($this->runners, function (RunnerInterface $runner) {
            return $runner instanceof FixableRunnerInterface;
        });
    }
}
