<?php

/**
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symplify\CodingStandard\Contract\Runner\RunnerInterface;

final class CheckCommand extends Command
{
    /**
     * @var RunnerInterface[]
     */
    private $runners = [];

    /**
     * @var OutputInterface
     */
    private $output;

    public function addRunner(RunnerInterface $runner)
    {
        $this->runners[] = $runner;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('check');
        $this->setDefinition([
            new InputArgument(
                'paths',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'The path(s) to be checked',
                null
            ),
        ]);
        $this->setDescription('Check coding standard in particular directory');
        $this->setHelp(<<<EOF
The <info>%command.name%</info> command checks coding standards
to one or more directories:

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
        $this->output = $output;

        try {
            foreach ($input->getArgument('paths') as $path) {
                $this->executeRunnerForDirectory($path);
            }

            return 0;
        } catch (Exception $exception) {
            $output->writeln(
                sprintf('<error>%s</error>', $exception->getMessage())
            );

            return 1;
        }
    }

    /**
     * @param string $path
     */
    private function executeRunnerForDirectory($path)
    {
        foreach ($this->runners as $runner) {
            $processOutput = $runner->runForDirectory($path);
            $this->output->writeln($processOutput);
        }
    }
}
