<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Course;

use Gember\EventSourcing\DomainContext\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\DomainContext\Attribute\DomainId;
use Gember\EventSourcing\DomainContext\EventSourcedDomainContext;
use Gember\EventSourcing\DomainContext\EventSourcedDomainContextBehaviorTrait;

/**
 * Traditional aggregate root.
 *
 * @implements EventSourcedDomainContext<Course>
 */
final class Course implements EventSourcedDomainContext
{
    /**
     * @use EventSourcedDomainContextBehaviorTrait<Course>
     */
    use EventSourcedDomainContextBehaviorTrait;

    /*
     * Define to which domain identifiers this context belongs to.
     */
    #[DomainId]
    private CourseId $courseId;

    /*
     * Use private properties to guard idempotency and protect invariants.
     */
    private string $name;

    public static function create(CourseId $courseId, string $name, int $capacity): self
    {
        $course = new self();
        $course->apply(new CourseCreatedEvent((string) $courseId, $name, $capacity));

        return $course;
    }

    public function rename(string $name): void
    {
        /*
         * Guard for idempotency.
         */
        if ($this->name === $name) {
            return;
        }

        /*
         * Apply events when all business rules are met.
         */
        $this->apply(new CourseRenamedEvent((string) $this->courseId, $name));
    }

    /*
     * Change internal state by subscribing to relevant domain events for any of the domain identifiers,
     * so that this context can apply its business rules.
     */
    #[DomainEventSubscriber]
    private function onCourseCreatedEvent(CourseCreatedEvent $event): void
    {
        $this->courseId = new CourseId($event->courseId);
        $this->name = $event->name;
    }

    #[DomainEventSubscriber]
    private function onCourseNameChangedEvent(CourseRenamedEvent $event): void
    {
        $this->name = $event->name;
    }
}
