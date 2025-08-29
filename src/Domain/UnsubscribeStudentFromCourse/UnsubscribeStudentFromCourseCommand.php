<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\UnsubscribeStudentFromCourse;

use Gember\EventSourcing\UseCase\Attribute\DomainTag;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;

/**
 * @see UnsubscribeStudentFromCourse
 */
final readonly class UnsubscribeStudentFromCourseCommand
{
    public function __construct(
        #[DomainTag]
        public StudentId $studentId,
        #[DomainTag]
        public CourseId $courseId,
    ) {}
}
