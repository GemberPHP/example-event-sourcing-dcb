<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Course;

/**
 * @see RenameCourseHandler
 */
final readonly class RenameCourseCommand
{
    public function __construct(
        public string $courseId,
        public string $name,
    ) {}
}
