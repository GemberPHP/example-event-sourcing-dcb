<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\CourseWaitlist;

use Gember\EventSourcing\Common\CreationPolicy;
use Gember\EventSourcing\Saga\Attribute\Saga;
use Gember\EventSourcing\Saga\Attribute\SagaEventSubscriber;
use Gember\EventSourcing\Saga\Attribute\SagaId;
use Gember\EventSourcing\Saga\CommandRecorder;
use Gember\ExampleEventSourcingDcb\Domain\ChangeCourseCapacity\CourseCapacityChangedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\RemoveStudentFromWaitlist\RemoveStudentFromWaitlistCommand;
use Gember\ExampleEventSourcingDcb\Domain\RemoveStudentFromWaitlist\StudentRemovedFromWaitlistEvent;
use Gember\ExampleEventSourcingDcb\Domain\Student\StudentId;
use Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse\StudentSubscribedToCourseEvent;
use Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse\StudentSubscriptionToCourseDeclinedEvent;
use Gember\ExampleEventSourcingDcb\Domain\SubscribeStudentToCourse\SubscribeStudentToCourseCommand;
use Gember\ExampleEventSourcingDcb\Domain\UnsubscribeStudentFromCourse\StudentUnsubscribedFromCourseEvent;
use Gember\ExampleEventSourcingDcb\Domain\WaitlistStudentForCourse\StudentWaitlistedForCourseEvent;
use Gember\ExampleEventSourcingDcb\Domain\WaitlistStudentForCourse\WaitlistStudentForCourseCommand;

/**
 * Saga that manages the course waitlist.
 *
 * When a student is waitlisted for a full course, this saga automatically
 * subscribes the next waitlisted student when a spot becomes available.
 */
#[Saga(name: 'course-waitlist')]
final class CourseWaitlistSaga
{
    #[SagaId]
    public ?string $courseId = null;

    /** @var list<string> */
    public array $waitlistedStudentIds = [];

    #[SagaEventSubscriber(policy: CreationPolicy::IfMissing)]
    public function onStudentSubscriptionToCourseDeclinedEvent(
        StudentSubscriptionToCourseDeclinedEvent $event,
        CommandRecorder $commandRecorder,
    ): void {
        $this->courseId = $event->courseId;

        $commandRecorder->record(new WaitlistStudentForCourseCommand(
            new StudentId($event->studentId),
            new CourseId($event->courseId),
        ));
    }

    #[SagaEventSubscriber(policy: CreationPolicy::IfMissing)]
    public function onStudentWaitlistedForCourseEvent(StudentWaitlistedForCourseEvent $event): void
    {
        $this->courseId = $event->courseId;

        if (!in_array($event->studentId, $this->waitlistedStudentIds, true)) {
            $this->waitlistedStudentIds[] = $event->studentId;
        }
    }

    #[SagaEventSubscriber]
    public function onStudentUnsubscribedFromCourseEvent(StudentUnsubscribedFromCourseEvent $event, CommandRecorder $commandRecorder): void
    {
        $this->subscribeNextWaitlistedStudent($commandRecorder);
    }

    #[SagaEventSubscriber]
    public function onCourseCapacityChangedEvent(CourseCapacityChangedEvent $event, CommandRecorder $commandRecorder): void
    {
        $this->subscribeNextWaitlistedStudent($commandRecorder);
    }

    #[SagaEventSubscriber]
    public function onStudentSubscribedToCourseEvent(StudentSubscribedToCourseEvent $event, CommandRecorder $commandRecorder): void
    {
        if (!in_array($event->studentId, $this->waitlistedStudentIds, true)) {
            return;
        }

        $commandRecorder->record(new RemoveStudentFromWaitlistCommand(
            new StudentId($event->studentId),
            new CourseId($event->courseId),
        ));
    }

    #[SagaEventSubscriber]
    public function onStudentRemovedFromWaitlistEvent(StudentRemovedFromWaitlistEvent $event, CommandRecorder $commandRecorder): void
    {
        $this->waitlistedStudentIds = array_values(
            array_filter(
                $this->waitlistedStudentIds,
                static fn(string $id): bool => $id !== $event->studentId,
            ),
        );

        $this->subscribeNextWaitlistedStudent($commandRecorder);
    }

    private function subscribeNextWaitlistedStudent(CommandRecorder $commandRecorder): void
    {
        if ($this->waitlistedStudentIds === [] || $this->courseId === null) {
            return;
        }

        $commandRecorder->record(new SubscribeStudentToCourseCommand(
            new StudentId($this->waitlistedStudentIds[0]),
            new CourseId($this->courseId),
        ));
    }
}
