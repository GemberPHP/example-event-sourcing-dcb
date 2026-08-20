<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command;

use Faker\Factory;
use Gember\DependencyContracts\EventStore\Rdbms\OptimisticLockException;
use Gember\ExampleEventSourcingDcb\Application\Command\Course\RenameCourseCommand;
use Gember\ExampleEventSourcingDcb\Domain\ChangeCourseCapacity\ChangeCourseCapacityCommand;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse\SubscribeStudentToCourseCommand;
use Gember\ExampleEventSourcingDcb\Domain\UnsubscribeStudentFromCourse\UnsubscribeStudentFromCourseCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

#[AsCommand(
    name: 'gember:demo:stress',
    description: 'Stress test with shared courses and students for concurrency testing.',
)]
final class DemoStressCommand extends Command
{
    private const string DEFAULT_INPUT_PATH = 'var/tmp/demo-fixtures.json';

    private const array ACTIONS = ['renameCourse', 'changeCourseCapacity', 'subscribeStudentToCourse', 'unsubscribeStudentFromCourse'];

    private const int MAX_RETRIES = 3;

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
        $this->addOption('iterations', 'i', InputOption::VALUE_REQUIRED, 'Number of iterations', 500);
        $this->addOption('input', null, InputOption::VALUE_REQUIRED, 'Input file path with fixture IDs', self::DEFAULT_INPUT_PATH);
        $this->addOption('sleep', 's', InputOption::VALUE_REQUIRED, 'Slow down iterations in seconds', 0);
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $inputPath */
        $inputPath = $input->getOption('input');

        if (!file_exists($inputPath)) {
            $output->writeln(sprintf('<error>Fixture file not found: %s. Run gember:demo:setup first.</error>', $inputPath));

            return self::FAILURE;
        }

        /** @var array{courses: list<string>, students: list<string>} $fixtures */
        $fixtures = json_decode(file_get_contents($inputPath), true, 512, JSON_THROW_ON_ERROR);

        $this->courses = $fixtures['courses'];
        $this->students = $fixtures['students'];

        if ($this->courses === [] || $this->students === []) {
            $output->writeln('<error>Fixture file contains no courses or students.</error>');

            return self::FAILURE;
        }

        $output->writeln(sprintf('Loaded %d courses and %d students from %s', count($this->courses), count($this->students), $inputPath));

        $iterations = (int) $input->getOption('iterations');
        $sleep = (int) $input->getOption('sleep');

        for ($i = 1; $i <= $iterations; ++$i) {
            $action = self::ACTIONS[random_int(0, count(self::ACTIONS) - 1)];

            $output->writeln(sprintf('%d. %s', $i, $action));

            $this->dispatchWithRetry($action);

            if ($sleep > 0) {
                sleep($sleep);
            }
        }

        return self::SUCCESS;
    }

    private function dispatchWithRetry(string $action): void
    {
        for ($attempt = 1; $attempt <= self::MAX_RETRIES; ++$attempt) {
            try {
                $this->{$action}();

                return;
            } catch (Throwable $exception) {
                if ($this->isRetryableException($exception) && $attempt < self::MAX_RETRIES) {
                    $this->output->writeln(sprintf(' <comment>⟳ Concurrency conflict, retrying (%d/%d)...</comment>', $attempt, self::MAX_RETRIES));
                    usleep(random_int(10_000, 100_000));

                    continue;
                }

                $this->output->writeln(sprintf('<error>%s</error>', $exception->getPrevious()?->getMessage()));

                return;
            }
        }
    }

    private function isRetryableException(Throwable $exception): bool
    {
        $current = $exception;

        while ($current !== null) {
            if ($current instanceof OptimisticLockException) {
                return true;
            }

            if (str_contains($current->getMessage(), 'Deadlock found')) {
                return true;
            }

            if ($current instanceof HandlerFailedException) {
                foreach ($current->getWrappedExceptions() as $wrapped) {
                    if ($this->isRetryableException($wrapped)) {
                        return true;
                    }
                }
            }

            $current = $current->getPrevious();
        }

        return false;
    }

    private function renameCourse(): void
    {
        $courseId = $this->courses[random_int(0, count($this->courses) - 1)];
        /** @var string $name */
        $name = Factory::create()->words(2, true);
        $name = ucfirst($name);

        $this->output->writeln(sprintf(' <info>Rename course %s to "%s"</info>', $courseId, $name));

        $this->commandBus->dispatch(new RenameCourseCommand($courseId, $name));
    }

    private function changeCourseCapacity(): void
    {
        $courseId = $this->courses[random_int(0, count($this->courses) - 1)];
        $capacity = random_int(1, 10);

        $this->output->writeln(sprintf(' <info>Change course %s capacity to %d</info>', $courseId, $capacity));

        $this->commandBus->dispatch(new ChangeCourseCapacityCommand(new CourseId($courseId), $capacity));
    }

    private function subscribeStudentToCourse(): void
    {
        $courseId = $this->courses[random_int(0, count($this->courses) - 1)];
        $studentId = $this->students[random_int(0, count($this->students) - 1)];

        $this->output->writeln(sprintf(' <info>Subscribe student %s to course %s</info>', $studentId, $courseId));

        $this->commandBus->dispatch(new SubscribeStudentToCourseCommand(
            new StudentId($studentId),
            new CourseId($courseId),
        ));
    }

    private function unsubscribeStudentFromCourse(): void
    {
        $courseId = $this->courses[random_int(0, count($this->courses) - 1)];
        $studentId = $this->students[random_int(0, count($this->students) - 1)];

        $this->output->writeln(sprintf(' <info>Unsubscribe student %s from course %s</info>', $studentId, $courseId));

        $this->commandBus->dispatch(new UnsubscribeStudentFromCourseCommand(
            new StudentId($studentId),
            new CourseId($courseId),
        ));
    }
}
