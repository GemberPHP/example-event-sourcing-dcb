<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription;

use Gember\EventSourcing\DomainContext\Attribute\DomainEvent;
use Gember\EventSourcing\DomainContext\Attribute\DomainId;

#[DomainEvent(name: 'student-to-course-subscription.student-unsubscribed-from-course')]
final readonly class StudentUnsubscribedFromCourseEvent
{
    public function __construct(
        #[DomainId]
        public string $courseId,
        #[DomainId]
        public string $studentId,
    ) {}
}
