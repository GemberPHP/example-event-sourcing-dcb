<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\ChangeCourseCapacity;

use Gember\EventSourcing\UseCase\Attribute\DomainEvent;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;

#[DomainEvent(name: 'course.capacity-changed')]
final readonly class CourseCapacityChangedEvent
{
    public function __construct(
        #[DomainTag]
        public string $courseId,
        public int $capacity,
    ) {}
}
