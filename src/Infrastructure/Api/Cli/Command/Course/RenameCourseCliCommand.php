<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command\Course;

use Gember\ExampleEventSourcingDcb\Application\Command\Course\RenameCourseCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'gember:course:rename',
    description: 'Rename course',
)]
final class RenameCourseCliCommand extends Command
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
        $this->addArgument('name', InputArgument::REQUIRED, 'Course name');
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(new RenameCourseCommand(
            $input->getArgument('courseId'),
            $input->getArgument('name'),
        ));

        $output->write('Course renamed to ' . $input->getArgument('name'));

        return self::SUCCESS;
    }
}
