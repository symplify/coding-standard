<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\CodingStandard\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symplify\CodingStandard\Contract\Runner\RunnerCollectionInterface;

final class FixCommand extends Command
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var RunnerCollectionInterface
     */
    private $runnerCollection;

    public function __construct(RunnerCollectionInterface $runnerCollection)
    {
        $this->runnerCollection = $runnerCollection;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('fix');
        $this->setDefinition([
            new InputArgument(
                'path',
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
        $this->output = $output;

        try {
            foreach ($input->getArgument('path') as $path) {
                $this->executeFixersForDirectory($path);
            }
            $output->writeln('<info>Your code was fixed!</info>');

            return 0;
        } catch (Exception $exception) {
            $output->writeln(
                sprintf('<error>%s</error>', $exception->getMessage())
            );

            return 1;
        }
    }

    /**
     * @param string $directory
     */
    private function executeFixersForDirectory($directory)
    {
        foreach ($this->runnerCollection->getRunners() as $fixableRunner) {
            $fixableRunner->fixDirectory($directory);
        }
    }
}
