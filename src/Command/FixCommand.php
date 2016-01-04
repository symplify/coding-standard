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
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\CodingStandard\Contract\Runner\RunnerCollectionInterface;

final class FixCommand extends Command
{
    /**
     * @var RunnerCollectionInterface
     */
    private $runnerCollection;

    /**
     * @var OutputInterface
     */
    private $io;

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
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);

        try {
            foreach ($input->getArgument('path') as $path) {
                $this->executeFixersForDirectory($path);
            }
            $this->io->success('Your code was successfully fixed!');

            return 0;
        } catch (Exception $exception) {
            $this->io->error($exception->getMessage());

            return 1;
        }
    }

    /**
     * @param string $directory
     */
    private function executeFixersForDirectory($directory)
    {
        foreach ($this->runnerCollection->getRunners() as $fixableRunner) {
            $processOutput = $fixableRunner->fixDirectory($directory);

            $this->io->writeln($processOutput);
        }
    }
}
