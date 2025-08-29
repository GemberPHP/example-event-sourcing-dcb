<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse;

use Gember\EventSourcing\UseCase\Attribute\DomainEvent;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;

#[DomainEvent(name: 'student-to-course-subscription.course-fully-booked')]
final readonly class CourseFullyBookedEvent
{
    public function __construct(
        #[DomainTag]
        public string $courseId,
    ) {}
}
