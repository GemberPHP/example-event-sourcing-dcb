<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Application\Command\Student;

use Gember\EventSourcing\Repository\UseCaseRepository;
use Gember\EventSourcing\Repository\UseCaseRepositoryFailedException;
use Gember\ExampleEventSourcingDcb\Domain\Student\Student;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class CreateStudentHandler
{
    public function __construct(
        private UseCaseRepository $repository,
    ) {}

    /**
     * @throws UseCaseRepositoryFailedException
     */
    #[AsMessageHandler(bus: 'command.bus')]
    public function __invoke(CreateStudentCommand $command): void
    {
        $studentId = new StudentId($command->studentId);

        if ($this->repository->has(Student::class, $studentId)) {
            return;
        }

        $course = Student::create($studentId);

        $this->repository->save($course);
    }
}
