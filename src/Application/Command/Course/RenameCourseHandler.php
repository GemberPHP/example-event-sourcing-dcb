<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Course;

use Gember\EventSourcing\Repository\UseCaseNotFoundException;
use Gember\EventSourcing\Repository\UseCaseRepository;
use Gember\EventSourcing\Repository\UseCaseRepositoryFailedException;
use Gember\ExampleEventSourcingDcb\Domain\Course\Course;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class RenameCourseHandler
{
    public function __construct(
        private UseCaseRepository $repository,
    ) {}

    /**
     * @throws UseCaseNotFoundException
     * @throws UseCaseRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(RenameCourseCommand $command): void
    {
        $course = $this->repository->get(Course::class, new CourseId($command->courseId));

        $course->rename($command->name);

        $this->repository->save($course);
    }
}
