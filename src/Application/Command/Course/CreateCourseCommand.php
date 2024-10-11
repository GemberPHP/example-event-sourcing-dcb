<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Course;

/**
 * @see CreateCourseHandler
 */
final readonly class CreateCourseCommand
{
    public function __construct(
        public string $courseId,
        public string $name,
        public int $capacity,
    ) {}
}
