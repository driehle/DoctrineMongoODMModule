<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModule\Collector\MongoLoggerCollector;
use DoctrineMongoODMModule\Service\MongoLoggerCollectorFactory;
use DoctrineMongoODMModuleTest\AbstractTestCase;

class MongoLoggerCollectorFactoryTest extends AbstractTestCase
{
    public function testCreateService(): void
    {
        $collector = $this->serviceManager->get('doctrine.mongo_logger_collector.odm_default');

        $this->assertInstanceOf(MongoLoggerCollector::class, $collector);
    }

    public function testCreateServiceWithLegacyCreateServiceMethod(): void
    {
        $factory = new MongoLoggerCollectorFactory('odm_default');

        $collector = $factory($this->serviceManager, MongoLoggerCollector::class);

        $this->assertInstanceOf(MongoLoggerCollector::class, $collector);
    }
}
