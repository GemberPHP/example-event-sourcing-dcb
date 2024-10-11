<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command\StudentToCourseSubscription;

use Gember\ExampleEventSourcingDcb\Application\Command\StudentToCourseSubscription\SubscribeStudentToCourseCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'gember:student-to-course-subscription:subscribe',
    description: 'Subscribe student to course',
)]
final class SubscribeStudentToCourseCliCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->addArgument('studentId', InputArgument::REQUIRED, 'Student ID');
        $this->addArgument('courseId', InputArgument::REQUIRED, 'Course ID');
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(new SubscribeStudentToCourseCommand(
            $input->getArgument('studentId'),
            $input->getArgument('courseId'),
        ));

        $output->write('Student # ' . $input->getArgument('studentId') . ' subscribed to course #' . $input->getArgument('courseId'));

        return self::SUCCESS;
    }
}
