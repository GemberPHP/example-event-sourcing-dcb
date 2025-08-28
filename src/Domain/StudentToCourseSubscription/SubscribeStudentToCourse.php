<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription;

use Gember\EventSourcing\UseCase\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;
use Gember\EventSourcing\UseCase\EventSourcedUseCase;
use Gember\EventSourcing\UseCase\EventSourcedUseCaseBehaviorTrait;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseCapacityChangedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseCreatedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseNotFoundException;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentCreatedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentNotFoundException;

/**
 * Use case based on multiple domain tags.
 */
final class SubscribeStudentToCourse implements EventSourcedUseCase
{
    use EventSourcedUseCaseBehaviorTrait;

    /*
     * Define to which domain tags this use case belongs to.
     */
    #[DomainTag]
    private CourseId $courseId;
    #[DomainTag]
    private StudentId $studentId;

    /*
     * Use private properties to guard idempotency and protect invariants.
     */
    private int $courseCapacity;
    private bool $isStudentSubscribedToCourse;
    private int $totalCountSubscriptionsForCourse;
    private int $totalCountSubscriptionsForStudent;

    /**
     * @throws CourseCannotAcceptMoreStudentsException
     * @throws CourseNotFoundException
     * @throws StudentCannotSubscribeToMoreCoursesException
     * @throws StudentNotFoundException
     */
    public function subscribe(): void
    {
        /*
         * Guard for idempotency.
         */
        if ($this->isStudentSubscribedToCourse ?? false) {
            return;
        }

        /*
         * Protect invariants (business rules).
         */
        $this->assertCourseExists();
        $this->assertStudentExists();
        $this->assertCourseHasSpotsAvailable();
        $this->assertStudentCanSubscribeToMoreCourses();

        /*
         * Apply events when all business rules are met.
         */
        $this->apply(new StudentSubscribedToCourseEvent((string) $this->courseId, (string) $this->studentId));

        if ($this->totalCountSubscriptionsForCourse >= $this->courseCapacity) {
            $this->apply(new CourseFullyBookedEvent((string) $this->courseId));
        }
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
     * @throws CourseCannotAcceptMoreStudentsException
     */
    private function assertCourseHasSpotsAvailable(): void
    {
        if ($this->totalCountSubscriptionsForCourse >= $this->courseCapacity) {
            throw CourseCannotAcceptMoreStudentsException::create();
        }
    }

    /**
     * @throws StudentCannotSubscribeToMoreCoursesException
     */
    private function assertStudentCanSubscribeToMoreCourses(): void
    {
        if ($this->totalCountSubscriptionsForStudent >= 10) {
            throw StudentCannotSubscribeToMoreCoursesException::create();
        }
    }

    /*
     * Change internal state by subscribing to relevant domain events for any of the domain tags,
     * so that this use case can apply its business rules.
     */
    #[DomainEventSubscriber]
    private function onCourseCreatedEvent(CourseCreatedEvent $event): void
    {
        $this->courseId = new CourseId($event->courseId);
        $this->courseCapacity = $event->capacity;
        $this->totalCountSubscriptionsForCourse = 0;
    }

    #[DomainEventSubscriber]
    private function onStudentCreatedEvent(StudentCreatedEvent $event): void
    {
        $this->studentId = new StudentId($event->studentId);
        $this->totalCountSubscriptionsForStudent = 0;
    }

    #[DomainEventSubscriber]
    private function onCourseCapacityChangedEvent(CourseCapacityChangedEvent $event): void
    {
        $this->courseCapacity = $event->capacity;
    }

    #[DomainEventSubscriber]
    private function onStudentSubscribedToCourseEvent(StudentSubscribedToCourseEvent $event): void
    {
        $studentId = $this->studentId ?? null;
        $courseId = $this->courseId ?? null;

        if ($studentId?->equals(new StudentId($event->studentId)) && $courseId?->equals(new CourseId($event->courseId))) {
            $this->isStudentSubscribedToCourse = true;
        }

        if ($courseId?->equals(new CourseId($event->courseId))) {
            ++$this->totalCountSubscriptionsForCourse;
        }

        if ($studentId?->equals(new StudentId($event->studentId))) {
            ++$this->totalCountSubscriptionsForStudent;
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

        if ($courseId?->equals(new CourseId($event->courseId))) {
            --$this->totalCountSubscriptionsForCourse;
        }

        if ($studentId?->equals(new StudentId($event->studentId))) {
            --$this->totalCountSubscriptionsForStudent;
        }
    }
}
