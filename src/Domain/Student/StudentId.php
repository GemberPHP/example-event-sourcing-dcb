<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Student;

use Override;
use Stringable;

final readonly class StudentId implements Stringable
{
    public function __construct(
        public string $id,
    ) {}

    #[Override]
    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(StudentId $studentId): bool
    {
        return $this->id === $studentId->id;
    }
}
