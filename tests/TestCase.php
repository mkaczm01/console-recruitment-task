<?php

declare(strict_types=1);

namespace Tests;

use Symfony\Component\Config\FileLocator;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class TestCase extends BaseTestCase
{
    protected ContainerBuilder $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../config'));
        $loader->load('services.yaml');
        $this->container->compile();
    }
}
