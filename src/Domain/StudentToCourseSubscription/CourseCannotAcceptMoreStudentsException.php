<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription;

use Exception;

final class CourseCannotAcceptMoreStudentsException extends Exception
{
    public static function create(): self
    {
        return new self('Course cannot accept more students');
    }
}
