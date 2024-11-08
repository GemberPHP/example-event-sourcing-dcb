<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Course;

use Gember\EventSourcing\DomainContext\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\DomainContext\Attribute\DomainId;
use Gember\EventSourcing\DomainContext\EventSourcedDomainContext;
use Gember\EventSourcing\DomainContext\EventSourcedDomainContextBehaviorTrait;

/**
 * Business decision model based one domain identifier.
 */
final class ChangeCourseCapacity implements EventSourcedDomainContext
{
    use EventSourcedDomainContextBehaviorTrait;

    /*
     * Define to which domain identifiers this context belongs to.
     */
    #[DomainId]
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
     * Change internal state by subscribing to relevant domain events for any of the domain identifiers,
     * so that this context can apply its business rules.
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
