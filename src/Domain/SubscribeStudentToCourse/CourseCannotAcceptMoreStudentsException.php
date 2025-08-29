<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse;

use Exception;

final class CourseCannotAcceptMoreStudentsException extends Exception
{
    public static function create(): self
    {
        return new self('Course cannot accept more students');
    }
}
