<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\RemoveStudentFromWaitlist;

use Gember\EventSourcing\Saga\Attribute\SagaId;
use Gember\EventSourcing\UseCase\Attribute\DomainEvent;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;

#[DomainEvent(name: 'course-waitlist.student-removed-from-waitlist')]
final readonly class StudentRemovedFromWaitlistEvent
{
    public function __construct(
        #[DomainTag]
        #[SagaId]
        public string $courseId,
        #[DomainTag]
        public string $studentId,
    ) {}
}
