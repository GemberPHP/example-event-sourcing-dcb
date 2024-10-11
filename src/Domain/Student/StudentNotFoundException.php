<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Student;

use Exception;

final class StudentNotFoundException extends Exception
{
    public static function create(): self
    {
        return new self('Student does not exist');
    }
}
