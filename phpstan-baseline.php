<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\ChangeCourseCapacity\\:\\:onCourseCapacityChangedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Course/ChangeCourseCapacity.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\ChangeCourseCapacity\\:\\:onCourseCreatedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Course/ChangeCourseCapacity.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\Course\\:\\:onCourseCreatedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Course/Course.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\Course\\:\\:onCourseNameChangedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Course/Course.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Student\\\\Student\\:\\:onStudentCreatedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Student/Student.php',
];
$ignoreErrors[] = [
	// identifier: property.onlyWritten
	'message' => '#^Property Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Student\\\\Student\\:\\:\\$studentId is never read, only written\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/Student/Student.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\SubscribeStudentToCourse\\:\\:onCourseCapacityChangedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\SubscribeStudentToCourse\\:\\:onCourseCreatedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\SubscribeStudentToCourse\\:\\:onStudentCreatedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\SubscribeStudentToCourse\\:\\:onStudentSubscribedToCourseEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\SubscribeStudentToCourse\\:\\:onStudentUnsubscribedFromCourseEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/SubscribeStudentToCourse.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\UnsubscribeStudentFromCourse\\:\\:onCourseCreatedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/UnsubscribeStudentFromCourse.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\UnsubscribeStudentFromCourse\\:\\:onStudentCreatedEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/UnsubscribeStudentFromCourse.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\UnsubscribeStudentFromCourse\\:\\:onStudentSubscribedToCourseEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/UnsubscribeStudentFromCourse.php',
];
$ignoreErrors[] = [
	// identifier: method.unused
	'message' => '#^Method Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\StudentToCourseSubscription\\\\UnsubscribeStudentFromCourse\\:\\:onStudentUnsubscribedFromCourseEvent\\(\\) is unused\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/StudentToCourseSubscription/UnsubscribeStudentFromCourse.php',
];
$ignoreErrors[] = [
	// identifier: cast.int
	'message' => '#^Cannot cast mixed to int\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/ChangeCourseCapacityCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#1 \\$courseId of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\Course\\\\ChangeCourseCapacityCommand constructor expects string, mixed given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/ChangeCourseCapacityCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: cast.int
	'message' => '#^Cannot cast mixed to int\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/CreateCourseCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#2 \\$name of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\Course\\\\CreateCourseCommand constructor expects string, mixed given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/CreateCourseCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#1 \\$courseId of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\Course\\\\RenameCourseCommand constructor expects string, mixed given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/RenameCourseCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#2 \\$name of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\Course\\\\RenameCourseCommand constructor expects string, mixed given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/Course/RenameCourseCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: cast.int
	'message' => '#^Cannot cast mixed to int\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoRunCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#1 \\$min \\(0\\) of function random_int expects lower number than parameter \\#2 \\$max \\(int\\<\\-1, max\\>\\)\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoRunCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#1 \\$studentId of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\StudentToCourseSubscription\\\\SubscribeStudentToCourseCommand constructor expects string, mixed given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/SubscribeStudentToCourseCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#2 \\$courseId of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\StudentToCourseSubscription\\\\SubscribeStudentToCourseCommand constructor expects string, mixed given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/SubscribeStudentToCourseCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#1 \\$studentId of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\StudentToCourseSubscription\\\\UnsubscribeStudentFromCourseCommand constructor expects string, mixed given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/UnsubscribeStudentFromCourseCliCommand.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#2 \\$courseId of class Gember\\\\ExampleEventSourcingDcb\\\\Application\\\\Command\\\\StudentToCourseSubscription\\\\UnsubscribeStudentFromCourseCommand constructor expects string, mixed given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/StudentToCourseSubscription/UnsubscribeStudentFromCourseCliCommand.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
