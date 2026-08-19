<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\WaitlistStudentForCourse;

use Gember\EventSourcing\Saga\Attribute\SagaId;
use Gember\EventSourcing\UseCase\Attribute\DomainEvent;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;

#[DomainEvent(name: 'course-waitlist.student-waitlisted-for-course')]
final readonly class StudentWaitlistedForCourseEvent
{
    public function __construct(
        #[DomainTag]
        #[SagaId]
        public string $courseId,
        #[DomainTag]
        public string $studentId,
    ) {}
}
