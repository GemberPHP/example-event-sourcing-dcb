<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription;

use Gember\EventSourcing\UseCase\Attribute\DomainEvent;
use Gember\EventSourcing\UseCase\Attribute\DomainId;

#[DomainEvent(name: 'student-to-course-subscription.student-subscribed-to-course')]
final readonly class StudentSubscribedToCourseEvent
{
    public function __construct(
        #[DomainId]
        public string $courseId,
        #[DomainId]
        public string $studentId,
    ) {}
}
