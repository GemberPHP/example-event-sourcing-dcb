<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Course;

use Gember\EventSourcing\DomainContext\Attribute\DomainEvent;
use Gember\EventSourcing\DomainContext\Attribute\DomainId;

#[DomainEvent(name: 'course.capacity-changed')]
final readonly class CourseCapacityChangedEvent
{
    public function __construct(
        #[DomainId]
        public string $courseId,
        public int $capacity,
    ) {}
}