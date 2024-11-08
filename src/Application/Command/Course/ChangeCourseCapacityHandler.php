<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Course;

use Gember\EventSourcing\Repository\DomainContextNotFoundException;
use Gember\EventSourcing\Repository\DomainContextRepository;
use Gember\EventSourcing\Repository\DomainContextRepositoryFailedException;
use Gember\ExampleEventSourcingDcb\Domain\Course\ChangeCourseCapacity;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class ChangeCourseCapacityHandler
{
    public function __construct(
        private DomainContextRepository $repository,
    ) {}

    /**
     * @throws CourseNotFoundException
     * @throws DomainContextNotFoundException
     * @throws DomainContextRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(ChangeCourseCapacityCommand $command): void
    {
        $context = $this->repository->get(ChangeCourseCapacity::class, new CourseId($command->courseId));

        $context->changeCapacity($command->capacity);

        $this->repository->save($context);
    }
}
