<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\WaitlistStudentForCourse;

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
use Gember\ExampleEventSourcingDcb\Domain\RemoveStudentFromWaitlist\StudentRemovedFromWaitlistEvent;
use Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse\StudentSubscribedToCourseEvent;
use Gember\ExampleEventSourcingDcb\Domain\UnsubscribeStudentFromCourse\StudentUnsubscribedFromCourseEvent;

/**
 * Use case for adding a student to a course waitlist.
 */
final class WaitlistStudentForCourse implements EventSourcedUseCase
{
    use EventSourcedUseCaseBehaviorTrait;

    #[DomainTag]
    private CourseId $courseId;
    #[DomainTag]
    private StudentId $studentId;

    private bool $isStudentOnWaitlist;
    private bool $isStudentSubscribedToCourse;

    /**
     * @throws CourseNotFoundException
     * @throws StudentNotFoundException
     * @throws StudentAlreadySubscribedToCourseException
     */
    #[DomainCommandHandler]
    public function __invoke(WaitlistStudentForCourseCommand $command): void
    {
        if ($this->isStudentOnWaitlist ?? false) {
            return;
        }

        $this->assertCourseExists();
        $this->assertStudentExists();
        $this->assertStudentIsNotAlreadySubscribed();

        $this->apply(new StudentWaitlistedForCourseEvent((string) $this->courseId, (string) $this->studentId));
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

    /**
     * @throws StudentAlreadySubscribedToCourseException
     */
    private function assertStudentIsNotAlreadySubscribed(): void
    {
        if ($this->isStudentSubscribedToCourse ?? false) {
            throw StudentAlreadySubscribedToCourseException::create();
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
        $this->isStudentSubscribedToCourse = false;
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

    #[DomainEventSubscriber]
    private function onStudentSubscribedToCourseEvent(StudentSubscribedToCourseEvent $event): void
    {
        $studentId = $this->studentId ?? null;
        $courseId = $this->courseId ?? null;

        if ($studentId?->equals(new StudentId($event->studentId)) && $courseId?->equals(new CourseId($event->courseId))) {
            $this->isStudentSubscribedToCourse = true;
            $this->isStudentOnWaitlist = false;
        }
    }

    #[DomainEventSubscriber]
    private function onStudentUnsubscribedFromCourseEvent(StudentUnsubscribedFromCourseEvent $event): void
    {
        $studentId = $this->studentId ?? null;
        $courseId = $this->courseId ?? null;

        if ($studentId?->equals(new StudentId($event->studentId)) && $courseId?->equals(new CourseId($event->courseId))) {
            $this->isStudentSubscribedToCourse = false;
        }
    }
}
