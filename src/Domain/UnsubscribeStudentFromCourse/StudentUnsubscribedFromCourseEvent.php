<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\UnsubscribeStudentFromCourse;

use Gember\EventSourcing\UseCase\Attribute\DomainEvent;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;

#[DomainEvent(name: 'student-to-course-subscription.student-unsubscribed-from-course')]
final readonly class StudentUnsubscribedFromCourseEvent
{
    public function __construct(
        #[DomainTag]
        public string $courseId,
        #[DomainTag]
        public string $studentId,
    ) {}
}
