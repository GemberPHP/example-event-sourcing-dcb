<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse;

use Gember\EventSourcing\Saga\Attribute\SagaId;
use Gember\EventSourcing\UseCase\Attribute\DomainEvent;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;

#[DomainEvent(name: 'student-to-course-subscription.student-subscription-to-course-declined')]
final readonly class StudentSubscriptionToCourseDeclinedEvent
{
    public function __construct(
        #[DomainTag]
        #[SagaId]
        public string $courseId,
        #[DomainTag]
        public string $studentId,
    ) {}
}
