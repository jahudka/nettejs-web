<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setDebugMode(strncmp($_SERVER['REMOTE_ADDR'], '172.20.10.', 10) === 0 || in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

Tracy\Debugger::setLogger(new Beetle\Tracy\Logger(__DIR__ . '/../log', [
    'consolePath' => '/srv/http/me/monokl/bugs/bin/console',
    'userId' => 2,
    'projectId' => 4,
]));

$container = $configurator->createContainer();

return $container;
