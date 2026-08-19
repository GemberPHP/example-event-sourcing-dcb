<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command\CourseWaitlist;

use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\WaitlistStudentForCourse\WaitlistStudentForCourseCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'gember:course-waitlist:waitlist',
    description: 'Add student to course waitlist',
)]
final class WaitlistStudentForCourseCliCommand extends Command
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
        $this->commandBus->dispatch(new WaitlistStudentForCourseCommand(
            new StudentId($input->getArgument('studentId')),
            new CourseId($input->getArgument('courseId')),
        ));

        $output->write('Student #' . $input->getArgument('studentId') . ' waitlisted for course #' . $input->getArgument('courseId'));

        return self::SUCCESS;
    }
}
