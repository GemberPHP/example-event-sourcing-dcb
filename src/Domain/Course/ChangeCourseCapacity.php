<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Course;

use Gember\EventSourcing\UseCase\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;
use Gember\EventSourcing\UseCase\EventSourcedUseCase;
use Gember\EventSourcing\UseCase\EventSourcedUseCaseBehaviorTrait;

/**
 * Use case based one domain tag.
 */
final class ChangeCourseCapacity implements EventSourcedUseCase
{
    use EventSourcedUseCaseBehaviorTrait;

    /*
     * Define to which domain tags this use case belongs to.
     */
    #[DomainTag]
    private CourseId $courseId;

    /*
     * Use private properties to guard idempotency and protect invariants.
     */
    private int $capacity;

    /**
     * @throws CourseNotFoundException
     */
    public function changeCapacity(int $capacity): void
    {
        /*
         * Guard for idempotency.
         */
        if ($this->capacity === $capacity) {
            return;
        }

        /*
         * Protect invariants (business rules).
         */
        if (!isset($this->courseId)) {
            throw CourseNotFoundException::create();
        }

        /*
         * Apply events when all business rules are met.
         */
        $this->apply(new CourseCapacityChangedEvent((string) $this->courseId, $capacity));
    }

    /*
     * Change internal state by subscribing to relevant domain events for any of the domain tags,
     * so that this use case can apply its business rules.
     */
    #[DomainEventSubscriber]
    private function onCourseCreatedEvent(CourseCreatedEvent $event): void
    {
        $this->courseId = new CourseId($event->courseId);
        $this->capacity = $event->capacity;
    }

    #[DomainEventSubscriber]
    private function onCourseCapacityChangedEvent(CourseCapacityChangedEvent $event): void
    {
        $this->capacity = $event->capacity;
    }
}
