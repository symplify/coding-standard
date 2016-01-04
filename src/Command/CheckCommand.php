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
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
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
     * @var int
     */
    private $exitCode = self::EXIT_CODE_SUCCESS;

    /**
     * @var RunnerCollectionInterface
     */
    private $runnerCollection;

    /**
     * @var StyleInterface
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
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);

        try {
            foreach ($input->getArgument('path') as $path) {
                $this->executeRunnersForDirectory($path);
            }

            return $this->outputCheckResult();
        } catch (Exception $exception) {
            $this->io->error($exception->getMessage());

            return 1;
        }
    }

    /**
     * @param string $directory
     */
    private function executeRunnersForDirectory($directory)
    {
        foreach ($this->runnerCollection->getRunners() as $runner) {
            $processOutput = $runner->runForDirectory($directory);
            $this->io->text($processOutput);

            if ($runner->hasErrors()) {
                $this->exitCode = self::EXIT_CODE_ERROR;
            }
        }
    }

    /**
     * @return int
     */
    private function outputCheckResult()
    {
        if ($this->exitCode === self::EXIT_CODE_ERROR) {
            $this->io->error('Some errors were found');

            return 1;
        }

        $this->io->success('Check was finished with no errors!');

        return 0;
    }
}
