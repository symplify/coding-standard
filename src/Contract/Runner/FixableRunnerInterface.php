<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Contract\Runner;

interface FixableRunnerInterface extends RunnerInterface
{
    /**
     * @param string $directory
     */
    public function fixDirectory($directory);
}
