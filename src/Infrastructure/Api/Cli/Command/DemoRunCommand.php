<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command;

use Faker\Factory;
use Gember\EventSourcing\Util\Generator\Identity\IdentityGenerator;
use Gember\ExampleEventSourcingDcb\Application\Command\Course\ChangeCourseCapacityCommand;
use Gember\ExampleEventSourcingDcb\Application\Command\Course\CreateCourseCommand;
use Gember\ExampleEventSourcingDcb\Application\Command\Course\RenameCourseCommand;
use Gember\ExampleEventSourcingDcb\Application\Command\Student\CreateStudentCommand;
use Gember\ExampleEventSourcingDcb\Application\Command\StudentToCourseSubscription\SubscribeStudentToCourseCommand;
use Gember\ExampleEventSourcingDcb\Application\Command\StudentToCourseSubscription\UnsubscribeStudentFromCourseCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;
use Override;

#[AsCommand(
    name: 'gember:demo',
    description: 'Demo run of POC; creating courses, students, subscribe, etc.',
)]
final class DemoRunCommand extends Command
{
    private const array ACTIONS_BASE = ['createCourse', 'createStudent'];
    private const array ACTIONS_COURSES = ['renameCourse', 'changeCourseCapacity'];
    private const array ACTIONS_SUBSCRIPTIONS = ['subscribeStudentToCourse', 'unsubscribeStudentFromCourse'];

    /**
     * @var list<string>
     */
    private array $courses = [];

    /**
     * @var list<string>
     */
    private array $students = [];

    private OutputInterface $output;

    public function __construct(
        private readonly IdentityGenerator $identityGenerator,
        private readonly MessageBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->output = $output;
    }

    #[Override]
    protected function configure(): void
    {
        $this->addOption('iterations', 'i', InputOption::VALUE_REQUIRED, 'Number of iterations', 20);
        $this->addOption('sleep', 's', InputOption::VALUE_REQUIRED, 'Slow down demo iterations in seconds', 1);
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        for ($i = 1; $i <= $input->getOption('iterations'); ++$i) {
            $action = $this->pickAction();

            $output->writeln(sprintf('%d. %s', $i, $action));

            try {
                $this->{$action}();
            } catch (Throwable $exception) {
                $output->writeln(sprintf('<error>%s</error>', $exception->getPrevious()?->getMessage()));
            }

            // Slow down demo
            sleep((int) $input->getOption('sleep'));
        }

        return self::SUCCESS;
    }

    private function pickAction(): string
    {
        /** @var list<string> $actions */
        $actions = [
            ...self::ACTIONS_BASE,
            ...self::ACTIONS_BASE,
            ...self::ACTIONS_COURSES,
            ...self::ACTIONS_SUBSCRIPTIONS,
            ...self::ACTIONS_SUBSCRIPTIONS,
        ];

        return $actions[random_int(0, count($actions) - 1)];
    }

    private function createCourse(): void
    {
        $courseId = $this->identityGenerator->generate();
        $capacity = random_int(1, 10);
        /** @var string $name */
        $name = Factory::create()->words(2, true);
        $name = ucfirst($name);

        $this->output->writeln(sprintf(' <info>Create course %s with name "%s" and capacity %d</info>', $courseId, $name, $capacity));

        $this->commandBus->dispatch(new CreateCourseCommand($courseId, $name, $capacity));

        $this->courses[] = $courseId;
    }

    private function createStudent(): void
    {
        $studentId = $this->identityGenerator->generate();
        $this->commandBus->dispatch(new CreateStudentCommand($studentId));

        $this->output->writeln(sprintf(' <info>Create student %s</info>', $studentId));

        $this->students[] = $studentId;
    }

    private function renameCourse(): void
    {
        if ($this->courses === []) {
            $this->output->writeln(' <comment>Nothing to trigger yet</comment>');

            return;
        }

        $courseId = $this->courses[random_int(0, count($this->courses) - 1)];
        /** @var string $name */
        $name = Factory::create()->words(2, true);
        $name = ucfirst($name);

        $this->output->writeln(sprintf(' <info>Rename course %s to "%s"</info>', $courseId, $name));

        $this->commandBus->dispatch(new RenameCourseCommand(
            $courseId,
            $name,
        ));
    }

    private function changeCourseCapacity(): void
    {
        if ($this->courses === []) {
            $this->output->writeln(' <comment>Nothing to trigger yet</comment>');

            return;
        }

        $courseId = $this->courses[random_int(0, count($this->courses) - 1)];
        $capacity = random_int(1, 10);

        $this->output->writeln(sprintf(' <info>Change course %s capacity to %d</info>', $courseId, $capacity));

        $this->commandBus->dispatch(new ChangeCourseCapacityCommand($courseId, $capacity));
    }

    private function subscribeStudentToCourse(): void
    {
        if ($this->courses === [] || $this->students === []) {
            $this->output->writeln(' <comment>Nothing to trigger yet</comment>');

            return;
        }

        $courseId = $this->courses[random_int(0, count($this->courses) - 1)];
        $studentId = $this->students[random_int(0, count($this->students) - 1)];

        $this->output->writeln(sprintf(' <info>Subscribe student %s to course %s</info>', $studentId, $courseId));

        $this->commandBus->dispatch(new SubscribeStudentToCourseCommand(
            $studentId,
            $courseId,
        ));
    }

    private function unsubscribeStudentFromCourse(): void
    {
        if ($this->courses === [] || $this->students === []) {
            $this->output->writeln(' <comment>Nothing to trigger yet</comment>');

            return;
        }

        $courseId = $this->courses[random_int(0, count($this->courses) - 1)];
        $studentId = $this->students[random_int(0, count($this->students) - 1)];

        $this->output->writeln(sprintf(' <info>Unsubscribe student %s from course %s</info>', $studentId, $courseId));

        $this->commandBus->dispatch(new UnsubscribeStudentFromCourseCommand(
            $studentId,
            $courseId,
        ));
    }
}
