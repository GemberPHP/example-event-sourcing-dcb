<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse;

use Gember\EventSourcing\UseCase\Attribute\DomainTag;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;

/**
 * @see SubscribeStudentToCourse
 */
final readonly class SubscribeStudentToCourseCommand
{
    public function __construct(
        #[DomainTag]
        public StudentId $studentId,
        #[DomainTag]
        public CourseId $courseId,
    ) {}
}
