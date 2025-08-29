<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\ChangeCourseCapacity;

use Gember\EventSourcing\UseCase\Attribute\DomainTag;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;

/**
 * @see ChangeCourseCapacity
 */
final readonly class ChangeCourseCapacityCommand
{
    public function __construct(
        #[DomainTag]
        public CourseId $courseId,
        public int $capacity,
    ) {}
}
