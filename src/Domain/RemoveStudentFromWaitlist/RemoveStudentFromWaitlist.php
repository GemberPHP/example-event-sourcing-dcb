<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\RemoveStudentFromWaitlist;

use Gember\EventSourcing\UseCase\Attribute\DomainCommandHandler;
use Gember\EventSourcing\UseCase\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;
use Gember\EventSourcing\UseCase\EventSourcedUseCase;
use Gember\EventSourcing\UseCase\EventSourcedUseCaseBehaviorTrait;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseCreatedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseNotFoundException;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentCreatedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentNotFoundException;
use Gember\ExampleEventSourcingDcb\Domain\WaitlistStudentForCourse\StudentWaitlistedForCourseEvent;

/**
 * Use case for removing a student from a course waitlist.
 */
final class RemoveStudentFromWaitlist implements EventSourcedUseCase
{
    use EventSourcedUseCaseBehaviorTrait;

    #[DomainTag]
    private CourseId $courseId;
    #[DomainTag]
    private StudentId $studentId;

    private bool $isStudentOnWaitlist;

    /**
     * @throws CourseNotFoundException
     * @throws StudentNotFoundException
     */
    #[DomainCommandHandler]
    public function __invoke(RemoveStudentFromWaitlistCommand $command): void
    {
        if (!($this->isStudentOnWaitlist ?? false)) {
            return;
        }

        $this->assertCourseExists();
        $this->assertStudentExists();

        $this->apply(new StudentRemovedFromWaitlistEvent((string) $this->courseId, (string) $this->studentId));
    }

    /**
     * @throws CourseNotFoundException
     */
    private function assertCourseExists(): void
    {
        if (!isset($this->courseId)) {
            throw CourseNotFoundException::create();
        }
    }

    /**
     * @throws StudentNotFoundException
     */
    private function assertStudentExists(): void
    {
        if (!isset($this->studentId)) {
            throw StudentNotFoundException::create();
        }
    }

    #[DomainEventSubscriber]
    private function onCourseCreatedEvent(CourseCreatedEvent $event): void
    {
        $this->courseId = new CourseId($event->courseId);
    }

    #[DomainEventSubscriber]
    private function onStudentCreatedEvent(StudentCreatedEvent $event): void
    {
        $this->studentId = new StudentId($event->studentId);
        $this->isStudentOnWaitlist = false;
    }

    #[DomainEventSubscriber]
    private function onStudentWaitlistedForCourseEvent(StudentWaitlistedForCourseEvent $event): void
    {
        $studentId = $this->studentId ?? null;
        $courseId = $this->courseId ?? null;

        if ($studentId?->equals(new StudentId($event->studentId)) && $courseId?->equals(new CourseId($event->courseId))) {
            $this->isStudentOnWaitlist = true;
        }
    }

    #[DomainEventSubscriber]
    private function onStudentRemovedFromWaitlistEvent(StudentRemovedFromWaitlistEvent $event): void
    {
        $studentId = $this->studentId ?? null;
        $courseId = $this->courseId ?? null;

        if ($studentId?->equals(new StudentId($event->studentId)) && $courseId?->equals(new CourseId($event->courseId))) {
            $this->isStudentOnWaitlist = false;
        }
    }
}
