# Event Sourcing with DCB in PHP
Example project (Proof of Concept) with Event Sourcing in PHP using the 'Dynamic Consistency Boundary' pattern (DCB).

## Background
'Dynamic Consistency Boundary' pattern is introduced by Sara Pellegrini in 2023 as a thought process (rethinking Event Sourcing).
Explained in her talk: ["The Aggregate is dead. Long live the Aggregate!"](https://sara.event-thinking.io/2023/04/kill-aggregate-chapter-1-I-am-here-to-kill-the-aggregate.html).

Currently, existing Event Sourcing frameworks rely on a consistent boundary within _aggregates_ (primary citizen), as explained in 'The blue book':

> Cluster the ENTITIES and VALUE OBJECTS into AGGREGATES and define boundaries around each.
Choose one ENTITY to be the root of each AGGREGATE, and control all access to the objects inside the boundary through the root. Allow external objects to hold reference to the root only.

_From "Domain-Driven Design: Tackling Complexity in the Heart of Software" by Eric Evans (the 'blue book')._

However, Event Sourcing with DCB has some advantages/solves some pitfalls over a traditional aggregate setup.

### Reusable domain events
In traditional event sourcing design, there's typically a strict one-to-one relationship between an aggregate and a domain event, which keeps the aggregate internally consistent. 
However, the DCB pattern removes this restriction by treating domain events as pure events.

This shift allows us to develop business decision models or domain models using specific subsets of domain events, even when they span across multiple domain identities.

This approach aligns well with how EventStorming currently conceptualizes aggregates. In [EventStorming](https://github.com/ddd-crew/eventstorming-glossary-cheat-sheet), these are often referred to as “systems” or “consistent business rules” 
rather than “aggregates” to make the concept more accessible to non-technical participants in the design process.

### No aggregate synchronisation nor domain services needed
As a domain event can be used by multiple business decision models, there is no synchronization needed between aggregates.
Duplicated events as well as domain services (typically to handle business logic spanning multiple aggregates) are not needed anymore.

### Concurrency problems
As an aggregate is based on internal consistency, two concurrent modification are impossible,
even when the modified data is (domain-wise) independent of each other.
The DCB pattern removes this blocking behavior when handled by multiple business decision models.

**But overall it removes accidental complexity which aggregates introduced, allowing to build software closer to the real world.**

More details, pros and cons explained (highly recommended):
- https://sara.event-thinking.io/2023/04/kill-aggregate-chapter-1-I-am-here-to-kill-the-aggregate.html
- https://www.youtube.com/watch?v=wXt54BawI-8
- https://www.axoniq.io/blog/rethinking-microservices-architecture-through-dynamic-consistency-boundaries

## This example project
_The DCB pattern is an interesting concept, but this does not advocate to remove aggregates completely.
Instead, a hybrid solution with aggregates and business decision models is probably more likely, depending on your domain._

This example project is using a fictive domain (taken from Sara Pellegrini's blog) where students can subscribe to courses (of any kind).
Deliberately this is all what is defined for this domain, to focus on how this could be implemented when using Event Sourcing with the DCB pattern in mind.

It contains both classic aggregates (e.g. [Course](src/Domain/Course/Course.php), [Student](src/Domain/Student/Student.php)) as well as business decision models (e.g. [ChangeCourseCapacity](src/Domain/Course/ChangeCourseCapacity.php), [SubscribeStudentToCourse](src/Domain/StudentToCourseSubscription/SubscribeStudentToCourse.php), [UnsubscribeStudentFromCourse](src/Domain/StudentToCourseSubscription/UnsubscribeStudentFromCourse.php)).

Inspired by other PHP libraries such as [Broadway](https://github.com/broadway), [EventSauce](https://github.com/EventSaucePHP), [Prooph](https://github.com/prooph) and [Ecotone](https://github.com/ecotoneframework) as well as [Axon Framework](https://github.com/AxonFramework) for Java.

### How to run
Run database with Docker compose:
```
docker compose up
```

Run migrations:
```
bin/console doctrine:migrations:migrate
```

You're all set, see what commands you can run:
```
bin/console gember
```

Or run the demo command to run random sets of commands automatically:
```
bin/console gember:demo
```
