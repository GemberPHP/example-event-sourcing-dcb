<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command\Course;

use Gember\ExampleEventSourcingDcb\Application\Command\Course\ChangeCourseCapacityCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'gember:course:change-capacity',
    description: 'Change course capacity',
)]
final class ChangeCourseCapacityCliCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->addArgument('courseId', InputArgument::REQUIRED, 'Course ID');
        $this->addArgument('capacity', InputArgument::REQUIRED, 'Course capacity');
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(new ChangeCourseCapacityCommand(
            $input->getArgument('courseId'),
            (int) $input->getArgument('capacity'),
        ));

        $output->write('Course capacity updated to ' . $input->getArgument('capacity'));

        return self::SUCCESS;
    }
}
