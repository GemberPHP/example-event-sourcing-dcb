<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\WaitlistStudentForCourse;

use Exception;

final class StudentAlreadySubscribedToCourseException extends Exception
{
    public static function create(): self
    {
        return new self('Student is already subscribed to this course');
    }
}
