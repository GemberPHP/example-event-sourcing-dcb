<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\StudentToCourseSubscription;

use Gember\EventSourcing\Repository\DomainContextNotFoundException;
use Gember\EventSourcing\Repository\DomainContextRepository;
use Gember\EventSourcing\Repository\DomainContextRepositoryFailedException;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseNotFoundException;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentNotFoundException;
use Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription\UnsubscribeStudentFromCourse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class UnsubscribeStudentFromCourseHandler
{
    public function __construct(
        private DomainContextRepository $repository,
    ) {}

    /**
     * @throws CourseNotFoundException
     * @throws StudentNotFoundException
     * @throws DomainContextNotFoundException
     * @throws DomainContextRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(UnsubscribeStudentFromCourseCommand $command): void
    {
        $context = $this->repository->get(
            UnsubscribeStudentFromCourse::class,
            new CourseId($command->courseId),
            new StudentId($command->studentId),
        );

        $context->unsubscribe();

        $this->repository->save($context);
    }
}
