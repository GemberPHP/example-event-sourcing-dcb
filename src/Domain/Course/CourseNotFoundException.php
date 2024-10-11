<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Course;

use Exception;

final class CourseNotFoundException extends Exception
{
    public static function create(): self
    {
        return new self('Course does not exist');
    }
}
