<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTestCase;

class AuthenticationStorageFactoryTest extends AbstractTestCase
{
    public function testAuthenticationStorageFactory(): void
    {
        $storage = $this->serviceManager->get('doctrine.authenticationstorage.odm_default');
        $this->assertInstanceOf('Laminas\Authentication\Storage\StorageInterface', $storage);
    }
}
