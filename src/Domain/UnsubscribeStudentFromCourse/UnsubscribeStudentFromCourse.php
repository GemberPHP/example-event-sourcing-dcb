<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\UnsubscribeStudentFromCourse;

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
use Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse\StudentSubscribedToCourseEvent;

/**
 * Use case based on multiple domain tags.
 */
final class UnsubscribeStudentFromCourse implements EventSourcedUseCase
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
    private bool $isStudentSubscribedToCourse;

    /**
     * @throws CourseNotFoundException
     * @throws StudentNotFoundException
     */
    #[DomainCommandHandler]
    public function __invoke(UnsubscribeStudentFromCourseCommand $command): void
    {
        /*
         * Guard for idempotency.
         */
        if (!($this->isStudentSubscribedToCourse ?? false)) {
            return;
        }

        /*
         * Protect invariants (business rules).
         */
        $this->assertCourseExists();
        $this->assertStudentExists();

        /*
         * Apply events when all business rules are met.
         */
        $this->apply(new StudentUnsubscribedFromCourseEvent((string) $this->courseId, (string) $this->studentId));
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

    /*
     * Change internal state by subscribing to relevant domain events for any of the domain tags,
     * so that this use case can apply its business rules.
     */
    #[DomainEventSubscriber]
    private function onCourseCreatedEvent(CourseCreatedEvent $event): void
    {
        $this->courseId = new CourseId($event->courseId);
    }

    #[DomainEventSubscriber]
    private function onStudentCreatedEvent(StudentCreatedEvent $event): void
    {
        $this->studentId = new StudentId($event->studentId);
    }

    #[DomainEventSubscriber]
    private function onStudentSubscribedToCourseEvent(StudentSubscribedToCourseEvent $event): void
    {
        $studentId = $this->studentId ?? null;
        $courseId = $this->courseId ?? null;

        if ($studentId?->equals(new StudentId($event->studentId)) && $courseId?->equals(new CourseId($event->courseId))) {
            $this->isStudentSubscribedToCourse = true;
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
