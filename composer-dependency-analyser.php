<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

$config->addPathToScan(__DIR__ . '/bin', isDev: false);
$config->addPathToScan(__DIR__ . '/config', isDev: true);
$config->addPathToScan(__DIR__ . '/public', isDev: false);

$config->ignoreErrorsOnPackage('doctrine/doctrine-bundle', [ErrorType::PROD_DEPENDENCY_ONLY_IN_DEV]);
$config->ignoreErrorsOnPackage('doctrine/doctrine-migrations-bundle', [ErrorType::PROD_DEPENDENCY_ONLY_IN_DEV]);
$config->ignoreErrorsOnPackage('gember/event-sourcing-symfony-bundle', [ErrorType::PROD_DEPENDENCY_ONLY_IN_DEV]);

$config->ignoreErrorsOnPackage('doctrine/dbal', [ErrorType::UNUSED_DEPENDENCY]);
$config->ignoreErrorsOnPackage('doctrine/orm', [ErrorType::UNUSED_DEPENDENCY]);
$config->ignoreErrorsOnPackage('symfony/dotenv', [ErrorType::UNUSED_DEPENDENCY]);
$config->ignoreErrorsOnPackage('symfony/flex', [ErrorType::UNUSED_DEPENDENCY]);
$config->ignoreErrorsOnPackage('symfony/runtime', [ErrorType::UNUSED_DEPENDENCY]);
$config->ignoreErrorsOnPackage('symfony/yaml', [ErrorType::UNUSED_DEPENDENCY]);

$config->ignoreErrorsOnExtension('ext-ctype', [ErrorType::UNUSED_DEPENDENCY]);
$config->ignoreErrorsOnExtension('ext-iconv', [ErrorType::UNUSED_DEPENDENCY]);

return $config;
