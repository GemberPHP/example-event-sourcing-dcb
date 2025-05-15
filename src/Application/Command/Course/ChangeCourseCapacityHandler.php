<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Course;

use Gember\EventSourcing\Repository\UseCaseNotFoundException;
use Gember\EventSourcing\Repository\UseCaseRepository;
use Gember\EventSourcing\Repository\UseCaseRepositoryFailedException;
use Gember\ExampleEventSourcingDcb\Domain\Course\ChangeCourseCapacity;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class ChangeCourseCapacityHandler
{
    public function __construct(
        private UseCaseRepository $repository,
    ) {}

    /**
     * @throws CourseNotFoundException
     * @throws UseCaseNotFoundException
     * @throws UseCaseRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(ChangeCourseCapacityCommand $command): void
    {
        $useCase = $this->repository->get(ChangeCourseCapacity::class, new CourseId($command->courseId));

        $useCase->changeCapacity($command->capacity);

        $this->repository->save($useCase);
    }
}
