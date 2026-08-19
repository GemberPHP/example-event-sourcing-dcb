<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command;

use Gember\DependencyContracts\Util\Generator\Identity\IdentityGenerator;
use Gember\ExampleEventSourcingDcb\Application\Command\Course\CreateCourseCommand;
use Gember\ExampleEventSourcingDcb\Application\Command\Student\CreateStudentCommand;
use Gember\ExampleEventSourcingDcb\Domain\ChangeCourseCapacity\ChangeCourseCapacityCommand;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse\SubscribeStudentToCourseCommand;
use Gember\ExampleEventSourcingDcb\Domain\UnsubscribeStudentFromCourse\UnsubscribeStudentFromCourseCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'gember:demo:waitlist',
    description: 'Demo the waitlist saga: create course (capacity 3), 8 students, subscribe 5, unsubscribe 1, increase capacity, unsubscribe 1',
)]
final class DemoWaitlistCommand extends Command
{
    public function __construct(
        private readonly IdentityGenerator $identityGenerator,
        private readonly MessageBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Create course with capacity 3
        $courseId = $this->identityGenerator->generate();
        $this->commandBus->dispatch(new CreateCourseCommand($courseId, 'Waitlist Demo Course', 3));
        $output->writeln(sprintf('<info>Created course %s (capacity 3)</info>', $courseId));

        // Create 8 students
        $studentIds = [];
        for ($i = 1; $i <= 8; ++$i) {
            $studentId = $this->identityGenerator->generate();
            $this->commandBus->dispatch(new CreateStudentCommand($studentId));
            $studentIds[] = $studentId;
            $output->writeln(sprintf('<info>Created student #%d: %s</info>', $i, $studentId));
        }

        // Subscribe students 1-5 (first 3 succeed, students 4+5 get declined → auto-waitlisted)
        for ($i = 0; $i < 5; ++$i) {
            $this->commandBus->dispatch(new SubscribeStudentToCourseCommand(
                new StudentId($studentIds[$i]),
                new CourseId($courseId),
            ));
            $output->writeln(sprintf('<comment>Subscribe student #%d: %s</comment>', $i + 1, $studentIds[$i]));
        }

        // Unsubscribe student 1 (opens 1 spot → saga auto-subscribes student 4)
        $this->commandBus->dispatch(new UnsubscribeStudentFromCourseCommand(
            new StudentId($studentIds[0]),
            new CourseId($courseId),
        ));
        $output->writeln(sprintf('<comment>Unsubscribe student #1: %s</comment>', $studentIds[0]));

        // Increase capacity from 3 to 5 (+2 spots → saga auto-subscribes student 5)
        $this->commandBus->dispatch(new ChangeCourseCapacityCommand(new CourseId($courseId), 5));
        $output->writeln('<comment>Change course capacity to 5</comment>');

        // Unsubscribe student 2 (opens 1 more spot, but waitlist is empty now)
        $this->commandBus->dispatch(new UnsubscribeStudentFromCourseCommand(
            new StudentId($studentIds[1]),
            new CourseId($courseId),
        ));
        $output->writeln(sprintf('<comment>Unsubscribe student #2: %s</comment>', $studentIds[1]));

        $output->writeln('');
        $output->writeln('<info>Done. Check event store and saga store for results.</info>');
        $output->writeln(sprintf('Course ID: %s', $courseId));

        return self::SUCCESS;
    }
}
