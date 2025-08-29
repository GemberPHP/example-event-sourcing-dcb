<?php

declare(strict_types=1);

namespace Gember\ExampleEventSourcingDcb\Domain\ChangeCourseCapacity;

use Gember\EventSourcing\UseCase\Attribute\DomainCommandHandler;
use Gember\EventSourcing\UseCase\Attribute\DomainEventSubscriber;
use Gember\EventSourcing\UseCase\Attribute\DomainTag;
use Gember\EventSourcing\UseCase\EventSourcedUseCase;
use Gember\EventSourcing\UseCase\EventSourcedUseCaseBehaviorTrait;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseCreatedEvent;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseId;
use Gember\ExampleEventSourcingDcb\Domain\Course\CourseNotFoundException;

/**
 * Use case based one domain tag.
 */
final class ChangeCourseCapacity implements EventSourcedUseCase
{
    use EventSourcedUseCaseBehaviorTrait;

    /*
     * Define to which domain tags this use case belongs to.
     */
    #[DomainTag]
    private CourseId $courseId;

    /*
     * Use private properties to guard idempotency and protect invariants.
     */
    private int $capacity;

    /**
     * @throws CourseNotFoundException
     */
    #[DomainCommandHandler]
    public function __invoke(ChangeCourseCapacityCommand $command): void
    {
        /*
         * Guard for idempotency.
         */
        if ($this->capacity === $command->capacity) {
            return;
        }

        /*
         * Protect invariants (business rules).
         */
        $this->assertCourseExists();

        /*
         * Apply events when all business rules are met.
         */
        $this->apply(new CourseCapacityChangedEvent((string) $this->courseId, $command->capacity));
    }

    /**
     * @throws CourseNotFoundException
     */
    private function assertCourseExists(): void
    {
        if (!isset($this->courseId)) {
            throw CourseNotFoundException::create();
        }
    }

    /*
     * Change internal state by subscribing to relevant domain events for any of the domain tags,
     * so that this use case can apply its business rules.
     */
    #[DomainEventSubscriber]
    private function onCourseCreatedEvent(CourseCreatedEvent $event): void
    {
        $this->courseId = new CourseId($event->courseId);
        $this->capacity = $event->capacity;
    }

    #[DomainEventSubscriber]
    private function onCourseCapacityChangedEvent(CourseCapacityChangedEvent $event): void
    {
        $this->capacity = $event->capacity;
    }
}
