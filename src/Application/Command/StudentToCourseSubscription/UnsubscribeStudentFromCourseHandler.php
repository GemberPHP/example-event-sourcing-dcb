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
use Gember\ExampleEventSourcingDcb\Domain\StudentToCourseSubscription\UnsubscribeStudentFromCourse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class UnsubscribeStudentFromCourseHandler
{
    public function __construct(
        private UseCaseRepository $repository,
    ) {}

    /**
     * @throws CourseNotFoundException
     * @throws StudentNotFoundException
     * @throws UseCaseNotFoundException
     * @throws UseCaseRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(UnsubscribeStudentFromCourseCommand $command): void
    {
        $useCase = $this->repository->get(
            UnsubscribeStudentFromCourse::class,
            new CourseId($command->courseId),
            new StudentId($command->studentId),
        );

        $useCase->unsubscribe();

        $this->repository->save($useCase);
    }
}
