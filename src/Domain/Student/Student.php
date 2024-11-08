<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Student;

use Gember\EventSourcing\DomainContext\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\DomainContext\Attribute\DomainId;
use Gember\EventSourcing\DomainContext\EventSourcedDomainContext;
use Gember\EventSourcing\DomainContext\EventSourcedDomainContextBehaviorTrait;

/**
 * Traditional aggregate root.
 */
final class Student implements EventSourcedDomainContext
{
    use EventSourcedDomainContextBehaviorTrait;

    /*
     * Define to which domain identifiers this context belongs to.
     */
    #[DomainId]
    private StudentId $studentId;

    public static function create(StudentId $studentId): self
    {
        $student = new self();
        $student->apply(new StudentCreatedEvent((string) $studentId));

        return $student;
    }

    /*
     * Change internal state by subscribing to relevant domain events for any of the domain identifiers,
     * so that this context can apply its business rules.
     */
    #[DomainEventSubscriber]
    private function onStudentCreatedEvent(StudentCreatedEvent $event): void
    {
        $this->studentId = new StudentId($event->studentId);
    }
}
