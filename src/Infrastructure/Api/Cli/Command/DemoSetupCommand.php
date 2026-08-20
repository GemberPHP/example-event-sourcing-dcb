<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command;

use Faker\Factory;
use Gember\DependencyContracts\Util\Generator\Identity\IdentityGenerator;
use Gember\ExampleEventSourcingDcb\Application\Command\Course\CreateCourseCommand;
use Gember\ExampleEventSourcingDcb\Application\Command\Student\CreateStudentCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

#[AsCommand(
    name: 'gember:demo:setup',
    description: 'Create shared courses and students for concurrency stress testing.',
)]
final class DemoSetupCommand extends Command
{
    private const string DEFAULT_OUTPUT_PATH = 'var/tmp/demo-fixtures.json';

    public function __construct(
        private readonly IdentityGenerator $identityGenerator,
        private readonly MessageBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->addOption('courses', 'c', InputOption::VALUE_REQUIRED, 'Number of courses to create', 10);
        $this->addOption('students', 's', InputOption::VALUE_REQUIRED, 'Number of students to create', 50);
        $this->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Output file path for fixture IDs', self::DEFAULT_OUTPUT_PATH);
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $courseCount = (int) $input->getOption('courses');
        $studentCount = (int) $input->getOption('students');
        /** @var string $outputPath */
        $outputPath = $input->getOption('output');

        $courses = [];
        $students = [];

        $output->writeln(sprintf('Creating %d courses...', $courseCount));

        for ($i = 1; $i <= $courseCount; ++$i) {
            $courseId = $this->identityGenerator->generate();
            $capacity = random_int(1, 10);
            /** @var string $name */
            $name = Factory::create()->words(2, true);
            $name = ucfirst($name);

            $output->writeln(sprintf(' <info>%d. Create course %s with name "%s" and capacity %d</info>', $i, $courseId, $name, $capacity));

            try {
                $this->commandBus->dispatch(new CreateCourseCommand($courseId, $name, $capacity));
                $courses[] = $courseId;
            } catch (Throwable $exception) {
                $output->writeln(sprintf('<error>%s</error>', $exception->getPrevious()?->getMessage()));
            }
        }

        $output->writeln(sprintf('Creating %d students...', $studentCount));

        for ($i = 1; $i <= $studentCount; ++$i) {
            $studentId = $this->identityGenerator->generate();

            $output->writeln(sprintf(' <info>%d. Create student %s</info>', $i, $studentId));

            try {
                $this->commandBus->dispatch(new CreateStudentCommand($studentId));
                $students[] = $studentId;
            } catch (Throwable $exception) {
                $output->writeln(sprintf('<error>%s</error>', $exception->getPrevious()?->getMessage()));
            }
        }

        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($outputPath, json_encode([
            'courses' => $courses,
            'students' => $students,
        ], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

        $output->writeln(sprintf('<comment>Fixtures written to %s (%d courses, %d students)</comment>', $outputPath, count($courses), count($students)));

        return self::SUCCESS;
    }
}
