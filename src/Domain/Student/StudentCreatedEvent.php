<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Student;

use Gember\EventSourcing\UseCase\Attribute\DomainEvent;
use Gember\EventSourcing\UseCase\Attribute\DomainId;

#[DomainEvent(name: 'student.created')]
final readonly class StudentCreatedEvent
{
    public function __construct(
        #[DomainId]
        public string $studentId,
    ) {}
}
