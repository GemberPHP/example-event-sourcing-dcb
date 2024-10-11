<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\Course;

use Override;
use Stringable;

final readonly class CourseId implements Stringable
{
    public function __construct(
        public string $id,
    ) {}

    #[Override]
    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(CourseId $courseId): bool
    {
        return $this->id === $courseId->id;
    }
}
