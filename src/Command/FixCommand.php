<?php

/**
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FixCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('fix');
        $this->setDefinition([
            new InputArgument(
                'paths',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'The path(s)',
                null
            ),
        ]);
        $this->setDescription('Fix coding standard in particular directory');
        $this->setHelp(<<<EOF
The <info>%command.name%</info> command fix coding standards
in one or more directories:

    <info>php %command.full_name% /path/to/dir</info>
    <info>php %command.full_name% /path/to/dir /path/to/another-dir</info>
EOF
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
