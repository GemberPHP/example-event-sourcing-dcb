<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription;

use Gember\EventSourcing\DomainContext\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\DomainContext\Attribute\DomainId;
use Gember\EventSourcing\DomainContext\EventSourcedDomainContext;
use Gember\EventSourcing\DomainContext\EventSourcedDomainContextBehaviorTrait;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseCapacityChangedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseCreatedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseNotFoundException;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentCreatedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentNotFoundException;

/**
 * Business decision model based on multiple domain identifiers.
 */
final class SubscribeStudentToCourse implements EventSourcedDomainContext
{
    use EventSourcedDomainContextBehaviorTrait;

    /*
     * Define to which domain identifiers this context belongs to.
     */
    #[DomainId]
    private CourseId $courseId;
    #[DomainId]
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
        if (!isset($this->courseId)) {
            throw CourseNotFoundException::create();
        }

        if (!isset($this->studentId)) {
            throw StudentNotFoundException::create();
        }

        if ($this->totalCountSubscriptionsForCourse >= $this->courseCapacity) {
            throw CourseCannotAcceptMoreStudentsException::create();
        }

        if ($this->totalCountSubscriptionsForStudent >= 10) {
            throw StudentCannotSubscribeToMoreCoursesException::create();
        }

        /*
         * Apply events when all business rules are met.
         */
        $this->apply(new StudentSubscribedToCourseEvent((string) $this->courseId, (string) $this->studentId));

        if ($this->totalCountSubscriptionsForCourse >= $this->courseCapacity) {
            $this->apply(new CourseFullyBookedEvent((string) $this->courseId));
        }
    }

    /*
     * Change internal state by subscribing to relevant domain events for any of the domain identifiers,
     * so that this context can apply its business rules.
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
