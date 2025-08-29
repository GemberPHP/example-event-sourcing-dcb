<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\ChangeCourseCapacity\\\\ChangeCourseCapacity\\:\\:onCourseCapacityChangedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/ChangeCourseCapacity/ChangeCourseCapacity.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\ChangeCourseCapacity\\\\ChangeCourseCapacity\\:\\:onCourseCreatedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/ChangeCourseCapacity/ChangeCourseCapacity.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\Course\\:\\:onCourseCreatedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Course/Course.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\Course\\:\\:onCourseRenamedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Course/Course.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Student\\\\Student\\:\\:onStudentCreatedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Student/Student.php',
];
$ignoreErrors[] = [
	'message' => '#^Property Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Student\\\\Student\\:\\:\\$studentId is never read, only written\\.$#',
	'identifier' => 'property.onlyWritten',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Student/Student.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\SubscribeStudentToCourse\\\\SubscribeStudentToCourse\\:\\:onCourseCapacityChangedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/SubscribeStudentToCourse/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\SubscribeStudentToCourse\\\\SubscribeStudentToCourse\\:\\:onCourseCreatedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/SubscribeStudentToCourse/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\SubscribeStudentToCourse\\\\SubscribeStudentToCourse\\:\\:onStudentCreatedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/SubscribeStudentToCourse/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\SubscribeStudentToCourse\\\\SubscribeStudentToCourse\\:\\:onStudentSubscribedToCourseEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/SubscribeStudentToCourse/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\SubscribeStudentToCourse\\\\SubscribeStudentToCourse\\:\\:onStudentUnsubscribedFromCourseEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/SubscribeStudentToCourse/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\UnsubscribeStudentFromCourse\\\\UnsubscribeStudentFromCourse\\:\\:onCourseCreatedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/UnsubscribeStudentFromCourse/UnsubscribeStudentFromCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\UnsubscribeStudentFromCourse\\\\UnsubscribeStudentFromCourse\\:\\:onStudentCreatedEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/UnsubscribeStudentFromCourse/UnsubscribeStudentFromCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\UnsubscribeStudentFromCourse\\\\UnsubscribeStudentFromCourse\\:\\:onStudentSubscribedToCourseEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/UnsubscribeStudentFromCourse/UnsubscribeStudentFromCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\UnsubscribeStudentFromCourse\\\\UnsubscribeStudentFromCourse\\:\\:onStudentUnsubscribedFromCourseEvent\\(\\) is unused\\.$#',
	'identifier' => 'method.unused',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/UnsubscribeStudentFromCourse/UnsubscribeStudentFromCourse.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between \'Course capacity…\' and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/ChangeCourseCapacityCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Cannot cast mixed to int\\.$#',
	'identifier' => 'cast.int',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/ChangeCourseCapacityCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\CourseId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/ChangeCourseCapacityCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Cannot cast mixed to int\\.$#',
	'identifier' => 'cast.int',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/CreateCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#2 \\$name of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\Course\\\\CreateCourseCommand constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/CreateCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between \'Course renamed to \' and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/RenameCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$courseId of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\Course\\\\RenameCourseCommand constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/RenameCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#2 \\$name of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\Course\\\\RenameCourseCommand constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/RenameCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Cannot cast mixed to int\\.$#',
	'identifier' => 'cast.int',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoRunCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$min \\(0\\) of function random_int expects lower number than parameter \\#2 \\$max \\(int\\<\\-1, max\\>\\)\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoRunCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between \'Student \\# \' and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/SubscribeStudentToCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between non\\-falsy\\-string and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/SubscribeStudentToCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\CourseId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/SubscribeStudentToCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Student\\\\StudentId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/SubscribeStudentToCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between \'Student \\# \' and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/UnsubscribeStudentFromCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between non\\-falsy\\-string and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/UnsubscribeStudentFromCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\CourseId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/UnsubscribeStudentFromCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Student\\\\StudentId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/UnsubscribeStudentFromCourseCliCommand.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
