<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse;

use Exception;

final class StudentCannotSubscribeToMoreCoursesException extends Exception
{
    public static function create(): self
    {
        return new self('Student cannot join more courses');
    }
}
