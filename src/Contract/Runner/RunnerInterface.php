<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Contract\Runner;

interface RunnerInterface
{
    /**
     * @param string $directory
     *
     * @return string
     */
    public function runForDirectory($directory);

    /**
     * @param string $directory
     */
    public function fixDirectory($directory);

    /**
     * @return bool
     */
    public function hasErrors();
}
