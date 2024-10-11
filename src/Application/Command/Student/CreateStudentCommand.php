<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Student;

/**
 * @see CreateStudentHandler
 */
final readonly class CreateStudentCommand
{
    public function __construct(
        public string $studentId,
    ) {}
}
