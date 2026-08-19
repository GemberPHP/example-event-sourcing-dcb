<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\ChangeCourseCapacity;

use Exception;

final class CourseCapacityBelowSubscriptionsException extends Exception
{
    public static function create(): self
    {
        return new self('Course capacity cannot be set below current subscription count');
    }
}
