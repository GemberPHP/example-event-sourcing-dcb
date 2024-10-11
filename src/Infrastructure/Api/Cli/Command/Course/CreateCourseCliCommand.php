<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command\Course;

use Gember\EventSourcing\Util\Generator\Identity\IdentityGenerator;
use Gember\ExampleEventSourcingDcb\Application\Command\Course\CreateCourseCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'gember:course:create',
    description: 'Create course',
)]
final class CreateCourseCliCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly IdentityGenerator $identityGenerator,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Course name');
        $this->addArgument('capacity', InputArgument::REQUIRED, 'Course capacity');
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $courseId = $this->identityGenerator->generate();

        $this->commandBus->dispatch(new CreateCourseCommand(
            $courseId,
            $input->getArgument('name'),
            (int) $input->getArgument('capacity'),
        ));

        $output->write('Created: course #' . $courseId);

        return self::SUCCESS;
    }
}
