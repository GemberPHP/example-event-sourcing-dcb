<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\StudentToCourseSubscription;

/**
 * @see UnsubscribeStudentFromCourseHandler
 */
final readonly class SubscribeStudentToCourseCommand
{
    public function __construct(
        public string $studentId,
        public string $courseId,
    ) {}
}
