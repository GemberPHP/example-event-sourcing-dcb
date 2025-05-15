<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Student;

use Gember\EventSourcing\UseCase\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\UseCase\Attribute\DomainId;
use Gember\EventSourcing\UseCase\EventSourcedUseCase;
use Gember\EventSourcing\UseCase\EventSourcedUseCaseBehaviorTrait;

/**
 * Traditional aggregate root.
 */
final class Student implements EventSourcedUseCase
{
    use EventSourcedUseCaseBehaviorTrait;

    /*
     * Define to which domain identifiers this use case belongs to.
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
     * so that this use case can apply its business rules.
     */
    #[DomainEventSubscriber]
    private function onStudentCreatedEvent(StudentCreatedEvent $event): void
    {
        $this->studentId = new StudentId($event->studentId);
    }
}
