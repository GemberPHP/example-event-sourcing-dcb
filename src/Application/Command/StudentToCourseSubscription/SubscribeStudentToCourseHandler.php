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
use Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription\CourseCannotAcceptMoreStudentsException;
use Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription\StudentCannotSubscribeToMoreCoursesException;
use Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription\SubscribeStudentToCourse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class SubscribeStudentToCourseHandler
{
    public function __construct(
        private DomainContextRepository $repository,
    ) {}

    /**
     * @throws CourseCannotAcceptMoreStudentsException
     * @throws CourseNotFoundException
     * @throws StudentCannotSubscribeToMoreCoursesException
     * @throws StudentNotFoundException
     * @throws DomainContextNotFoundException
     * @throws DomainContextRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(SubscribeStudentToCourseCommand $command): void
    {
        $context = $this->repository->get(
            SubscribeStudentToCourse::class,
            new CourseId($command->courseId),
            new StudentId($command->studentId),
        );

        $context->subscribe();

        $this->repository->save($context);
    }
}
