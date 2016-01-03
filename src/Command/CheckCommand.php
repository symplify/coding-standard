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

final class CheckCommand extends Command
{
    /**
     * @var int
     */
    const EXIT_CODE_SUCCESS = 0;

    /**
     * @var int
     */
    const EXIT_CODE_ERROR = 1;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var int
     */
    private $exitCode = self::EXIT_CODE_SUCCESS;

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
        $this->setName('check');
        $this->setDefinition([
            new InputArgument(
                'path',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'The path(s)',
                null
            ),
        ]);
        $this->setDescription('Check coding standard in particular directory');
        $this->setHelp(<<<EOF
The <info>%command.name%</info> command checks coding standards
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
                $this->executeRunnersForDirectory($path);
            }
            $output->writeln('<info>Check was finished!</info>');
        } catch (Exception $exception) {
            $output->writeln(
                sprintf('<error>%s</error>', $exception->getMessage())
            );

            $this->exitCode = self::EXIT_CODE_ERROR;
        }

        return $this->exitCode;
    }

    /**
     * @param string $directory
     */
    private function executeRunnersForDirectory($directory)
    {
        foreach ($this->runnerCollection->getRunners() as $runner) {
            $processOutput = $runner->runForDirectory($directory);
            $this->output->writeln($processOutput);

            if ($runner->hasErrors()) {
                $this->exitCode = self::EXIT_CODE_ERROR;
            }
        }
    }
}
