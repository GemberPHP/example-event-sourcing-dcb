<?php declare(strict_types = 1);

$ignoreErrors = [];
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
	'message' => '#^Binary operation "\\." between \'Student \\#\' and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/CourseWaitlist/RemoveStudentFromWaitlistCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between non\\-falsy\\-string and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/CourseWaitlist/RemoveStudentFromWaitlistCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\CourseId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/CourseWaitlist/RemoveStudentFromWaitlistCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Student\\\\StudentId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/CourseWaitlist/RemoveStudentFromWaitlistCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between \'Student \\#\' and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/CourseWaitlist/WaitlistStudentForCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Binary operation "\\." between non\\-falsy\\-string and mixed results in an error\\.$#',
	'identifier' => 'binaryOp.invalid',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/CourseWaitlist/WaitlistStudentForCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Course\\\\CourseId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/CourseWaitlist/WaitlistStudentForCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$id of class Gember\\\\ExampleEventSourcingDcb\\\\Domain\\\\Student\\\\StudentId constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/CourseWaitlist/WaitlistStudentForCourseCliCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Cannot cast mixed to int\\.$#',
	'identifier' => 'cast.int',
	'count' => 2,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoSetupCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Cannot cast mixed to int\\.$#',
	'identifier' => 'cast.int',
	'count' => 3,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoSnapshotCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Cannot cast mixed to string\\.$#',
	'identifier' => 'cast.string',
	'count' => 3,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoSnapshotCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Cannot cast mixed to int\\.$#',
	'identifier' => 'cast.int',
	'count' => 2,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoStressCommand.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$json of function json_decode expects string, string\\|false given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Infrastructure/Api/Cli/Command/DemoStressCommand.php',
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
