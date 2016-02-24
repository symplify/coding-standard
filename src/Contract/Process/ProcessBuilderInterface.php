<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Contract\Process;

use Symfony\Component\Process\Process;

interface ProcessBuilderInterface
{
    /**
     * @return Process
     */
    public function getProcess();
}
