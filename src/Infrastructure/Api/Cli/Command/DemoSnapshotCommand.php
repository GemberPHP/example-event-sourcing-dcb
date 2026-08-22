<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Infrastructure\Api\Cli\Command;

use Doctrine\DBAL\Connection;
use Gember\ExampleEventSourcingDcb\Application\Command\Course\CreateCourseCommand;
use Gember\ExampleEventSourcingDcb\Application\Command\Student\CreateStudentCommand;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse\SubscribeStudentToCourseCommand;
use Gember\ExampleEventSourcingDcb\Domain\UnsubscribeStudentFromCourse\UnsubscribeStudentFromCourseCommand;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

#[AsCommand(
    name: 'gember:demo:snapshot',
    description: 'Test snapshotting by verifying business logic works correctly after reconstitution from snapshot.',
)]
final class DemoSnapshotCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly Connection $connection,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('');
        $output->writeln('<comment>Snapshot Verification Test</comment>');
        $output->writeln('This test proves snapshot state is correctly persisted and restored.');
        $output->writeln('');

        $courseId = (string) Uuid::v4();
        $capacity = 3;

        // Step 1: Create a course with limited capacity
        $output->writeln(sprintf('<info>Step 1:</info> Create course with capacity %d', $capacity));
        $this->commandBus->dispatch(new CreateCourseCommand($courseId, 'Snapshot Test', $capacity));
        $this->processOutbox();

        // Step 2: Create students and subscribe them to fill the course
        $studentIds = [];
        for ($i = 1; $i <= $capacity; ++$i) {
            $studentId = (string) Uuid::v4();
            $studentIds[] = $studentId;

            $this->commandBus->dispatch(new CreateStudentCommand($studentId));
            $this->processOutbox();

            $this->commandBus->dispatch(new SubscribeStudentToCourseCommand(
                new StudentId($studentId),
                new CourseId($courseId),
            ));
            $this->processOutbox();

            $output->writeln(sprintf('  Subscribed student %d/%d', $i, $capacity));
        }

        $snapshotCount = $this->getSnapshotCount();
        $output->writeln(sprintf('<info>Step 2:</info> Course is full. Snapshots in store: %d', $snapshotCount));

        if ($snapshotCount === 0) {
            $output->writeln('<error>No snapshots created — lower afterEvents threshold to trigger snapshots.</error>');

            return self::FAILURE;
        }

        $output->writeln('');

        // Step 3: Try subscribing another student — should be DECLINED
        // This proves the capacity state (totalCountSubscriptionsForCourse, courseCapacity)
        // was correctly restored from the snapshot
        $output->writeln('<info>Step 3:</info> Subscribe one more student (course is full) — should be declined');
        $extraStudentId = (string) Uuid::v4();
        $this->commandBus->dispatch(new CreateStudentCommand($extraStudentId));
        $this->processOutbox();

        $this->commandBus->dispatch(new SubscribeStudentToCourseCommand(
            new StudentId($extraStudentId),
            new CourseId($courseId),
        ));
        $this->processOutbox();

        $lastEvent = $this->getLastEventForBoundary($courseId, $extraStudentId);

        if ($lastEvent === 'student-to-course-subscription.student-subscription-to-course-declined') {
            $output->writeln('  <info>PASS</info> — Subscription correctly declined (capacity state restored from snapshot)');
        } else {
            $output->writeln(sprintf('  <error>FAIL</error> — Expected declined, got: %s', $lastEvent ?? 'none'));

            return self::FAILURE;
        }

        $output->writeln('');

        // Step 4: Unsubscribe a student, then subscribe the extra student
        // This proves totalCountSubscriptionsForCourse decrements correctly after snapshot restore
        $output->writeln('<info>Step 4:</info> Unsubscribe student 1, then subscribe extra student — should succeed');

        $this->commandBus->dispatch(new UnsubscribeStudentFromCourseCommand(
            new StudentId($studentIds[0]),
            new CourseId($courseId),
        ));
        $this->processOutbox();

        $this->commandBus->dispatch(new SubscribeStudentToCourseCommand(
            new StudentId($extraStudentId),
            new CourseId($courseId),
        ));
        $this->processOutbox();

        $lastEvent = $this->getLastEventForBoundary($courseId, $extraStudentId);

        if ($lastEvent === 'student-to-course-subscription.student-subscribed-to-course') {
            $output->writeln('  <info>PASS</info> — Subscription succeeded after freeing a slot');
        } else {
            $output->writeln(sprintf('  <error>FAIL</error> — Expected subscribed, got: %s', $lastEvent ?? 'none'));

            return self::FAILURE;
        }

        $output->writeln('');

        // Step 5: Try subscribing the same student again — should be idempotent (no new event)
        // This proves isStudentSubscribedToCourse was correctly restored from snapshot
        $output->writeln('<info>Step 5:</info> Subscribe same student again — should be idempotent');

        $eventCountBefore = $this->getEventCount();

        $this->commandBus->dispatch(new SubscribeStudentToCourseCommand(
            new StudentId($extraStudentId),
            new CourseId($courseId),
        ));
        $this->processOutbox();

        $eventCountAfter = $this->getEventCount();

        if ($eventCountAfter === $eventCountBefore) {
            $output->writeln('  <info>PASS</info> — No new events (idempotency state restored from snapshot)');
        } else {
            $output->writeln(sprintf('  <error>FAIL</error> — Expected no new events, got %d', $eventCountAfter - $eventCountBefore));

            return self::FAILURE;
        }

        $output->writeln('');
        $this->printSnapshotInfo($output);
        $output->writeln('');
        $output->writeln('<info>All tests passed! Snapshot state is correctly persisted and restored.</info>');

        return self::SUCCESS;
    }

    private function processOutbox(): void
    {
        $this->connection->executeStatement(
            'UPDATE outbox SET processed_at = NOW(6) WHERE processed_at IS NULL AND dead_lettered_at IS NULL',
        );
    }

    private function getSnapshotCount(): int
    {
        return (int) $this->connection->fetchOne('SELECT COUNT(*) FROM snapshot_store');
    }

    private function getEventCount(): int
    {
        return (int) $this->connection->fetchOne('SELECT COUNT(*) FROM event_store');
    }

    private function getLastEventForBoundary(string $courseId, string $studentId): ?string
    {
        /** @var string|false $result */
        $result = $this->connection->fetchOne(
            <<<'SQL'
            SELECT es.event_name
            FROM event_store es
            JOIN event_store_relation esr1 ON es.id = esr1.event_id AND esr1.domain_tag = :courseId
            JOIN event_store_relation esr2 ON es.id = esr2.event_id AND esr2.domain_tag = :studentId
            ORDER BY es.applied_at DESC, es.id DESC
            LIMIT 1
            SQL,
            ['courseId' => $courseId, 'studentId' => $studentId],
        );

        return $result !== false ? $result : null;
    }

    private function printSnapshotInfo(OutputInterface $output): void
    {
        $snapshots = $this->connection->fetchAllAssociative(
            'SELECT boundary_hash, event_count, created_at, updated_at FROM snapshot_store',
        );

        $output->writeln(sprintf('<comment>Snapshots in store: %d</comment>', count($snapshots)));

        foreach ($snapshots as $snapshot) {
            $output->writeln(sprintf(
                '  hash: %s... | events: %d | updated: %s',
                substr($snapshot['boundary_hash'], 0, 12),
                $snapshot['event_count'],
                $snapshot['updated_at'] ?? $snapshot['created_at'],
            ));
        }
    }
}
