# Event Sourcing with DCB in PHP
Example project (Proof of Concept) with Event Sourcing in PHP using the 'Dynamic Consistency Boundary' (DCB) pattern.

More about the library and the DCB pattern, see [Gember Event Sourcing](https://github.com/GemberPHP/event-sourcing).

## This example project
_The DCB pattern is an interesting concept, but this does not advocate to remove aggregates completely.
Instead, a hybrid solution with aggregates and use cases is probably more likely, depending on your domain._

This example project is using a fictive domain (taken from Sara Pellegrini's blog) where students can subscribe to courses (of any kind).
Deliberately this is all what is defined for this domain, to focus on how this could be implemented when using Event Sourcing with the DCB pattern in mind.

It contains both classic aggregates (e.g. [Course](src/Domain/Course/Course.php), [Student](src/Domain/Student/Student.php)) as well as use cases (e.g. [ChangeCourseCapacity](src/Domain/ChangeCourseCapacity/ChangeCourseCapacity.php), [SubscribeStudentToCourse](src/Domain/SubscribeStudentToCourse/SubscribeStudentToCourse.php), [UnsubscribeStudentFromCourse](src/Domain/UnsubscribeStudentFromCourse/UnsubscribeStudentFromCourse.php)).

Inspired by other PHP libraries such as [Broadway](https://github.com/broadway), [EventSauce](https://github.com/EventSaucePHP), [Prooph](https://github.com/prooph) and [Ecotone](https://github.com/ecotoneframework) as well as [Axon Framework](https://github.com/AxonFramework) for Java.

### How to run
Requirements on the host: PHP 8.5 with `pdo_mysql` and `pcntl`, and Composer. Docker only runs MySQL.

Install the dependencies:
```
composer install
```

Run database with Docker compose (wait until MySQL accepts connections):
```
docker compose up -d
```

Run migrations:
```
bin/console doctrine:migrations:migrate
```

This app uses the outbox (`dispatch.strategy: outbox`): events and saga commands are dispatched by the outbox processor, so keep it running in a separate terminal:
```
bin/console gember:outbox:process --watch
```

You're all set, see what commands you can run:
```
bin/console gember
```

Or run the demo command to run random sets of commands concurrently:
```
# 1. Create shared fixtures (run once)
php bin/console gember:demo:setup --courses=10 --students=50

# 2. With the outbox processor running (see above), hammer them concurrently
seq 1 10 | xargs -P10 -I{} php bin/console gember:demo:stress --iterations=50
```
