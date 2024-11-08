<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Course;

use Gember\EventSourcing\Repository\DomainContextRepository;
use Gember\EventSourcing\Repository\DomainContextRepositoryFailedException;
use Gember\ExampleEventSourcingDcb\Domain\Course\Course;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class CreateCourseHandler
{
    public function __construct(
        private DomainContextRepository $repository,
    ) {}

    /**
     * @throws DomainContextRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(CreateCourseCommand $command): void
    {
        $courseId = new CourseId($command->courseId);

        if ($this->repository->has(Course::class, $courseId)) {
            return;
        }

        $course = Course::create($courseId, $command->name, $command->capacity);

        $this->repository->save($course);
    }
}
