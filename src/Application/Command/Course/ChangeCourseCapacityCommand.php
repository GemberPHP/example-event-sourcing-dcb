<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Course;

/**
 * @see ChangeCourseCapacityHandler
 */
final readonly class ChangeCourseCapacityCommand
{
    public function __construct(
        public string $courseId,
        public int $capacity,
    ) {}
}
