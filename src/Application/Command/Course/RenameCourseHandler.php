<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Course;

use Gember\EventSourcing\Repository\DomainContextNotFoundException;
use Gember\EventSourcing\Repository\DomainContextRepository;
use Gember\EventSourcing\Repository\DomainContextRepositoryFailedException;
use Gember\ExampleEventSourcingDcb\Domain\Course\Course;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class RenameCourseHandler
{
    public function __construct(
        private DomainContextRepository $repository,
    ) {}

    /**
     * @throws DomainContextNotFoundException
     * @throws DomainContextRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(RenameCourseCommand $command): void
    {
        $course = $this->repository->get(Course::class, new CourseId($command->courseId));

        $course->rename($command->name);

        $this->repository->save($course);
    }
}
