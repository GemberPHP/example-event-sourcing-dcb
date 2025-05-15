# Event Sourcing with DCB in PHP
Example project (Proof of Concept) with Event Sourcing in PHP using the 'Dynamic Consistency Boundary' (DCB) pattern.

More about the library and the DCB pattern, see [Gember Event Sourcing](https://github.com/GemberPHP/event-sourcing).

## This example project
_The DCB pattern is an interesting concept, but this does not advocate to remove aggregates completely.
Instead, a hybrid solution with aggregates and use cases is probably more likely, depending on your domain._

This example project is using a fictive domain (taken from Sara Pellegrini's blog) where students can subscribe to courses (of any kind).
Deliberately this is all what is defined for this domain, to focus on how this could be implemented when using Event Sourcing with the DCB pattern in mind.

It contains both classic aggregates (e.g. [Course](src/Domain/Course/Course.php), [Student](src/Domain/Student/Student.php)) as well as use cases (e.g. [ChangeCourseCapacity](src/Domain/Course/ChangeCourseCapacity.php), [SubscribeStudentToCourse](src/Domain/StudentToCourseSubscription/SubscribeStudentToCourse.php), [UnsubscribeStudentFromCourse](src/Domain/StudentToCourseSubscription/UnsubscribeStudentFromCourse.php)).

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
