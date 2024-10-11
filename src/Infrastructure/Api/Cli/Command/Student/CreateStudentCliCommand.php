<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command\Student;

use Gember\EventSourcing\Util\Generator\Identity\IdentityGenerator;
use Gember\ExampleEventSourcingDcb\Application\Command\Student\CreateStudentCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'gember:student:create',
    description: 'Create student',
)]
final class CreateStudentCliCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly IdentityGenerator $identityGenerator,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $studentId = $this->identityGenerator->generate();

        $this->commandBus->dispatch(new CreateStudentCommand(
            $studentId,
        ));

        $output->write('Created: student #' . $studentId);

        return self::SUCCESS;
    }
}
