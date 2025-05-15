<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\StudentToCourseSubscription;

use Gember\EventSourcing\Repository\UseCaseNotFoundException;
use Gember\EventSourcing\Repository\UseCaseRepository;
use Gember\EventSourcing\Repository\UseCaseRepositoryFailedException;
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
        private UseCaseRepository $repository,
    ) {}

    /**
     * @throws CourseCannotAcceptMoreStudentsException
     * @throws CourseNotFoundException
     * @throws StudentCannotSubscribeToMoreCoursesException
     * @throws StudentNotFoundException
     * @throws UseCaseNotFoundException
     * @throws UseCaseRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(SubscribeStudentToCourseCommand $command): void
    {
        $useCase = $this->repository->get(
            SubscribeStudentToCourse::class,
            new CourseId($command->courseId),
            new StudentId($command->studentId),
        );

        $useCase->subscribe();

        $this->repository->save($useCase);
    }
}
