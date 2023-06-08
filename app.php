#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\Commands\CommissionsCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__.'/vendor/autoload.php';

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load(__DIR__.'/config/services.yaml');
$container->compile();

$command = $container->get(CommissionsCommand::class);

$application = new Application('Recruitment Task', '1.0.0');
$application->add($command);
$application->setDefaultCommand($command->getName(), true);
$application->run();
