<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTestCase;
use DoctrineMongoODMModuleTest\Assets\CustomDocumentRepository;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;

final class CustomDefaultRepositoryTest extends AbstractTestCase
{
    public function testCustomDefaultRepository(): void
    {
        $documentManager = $this->getDocumentManager();

        $repository = $documentManager->getRepository(Simple::class);

        $this->assertInstanceOf(CustomDocumentRepository::class, $repository);
        $this->assertTrue($repository->isCustomDefaultDocumentRepository());
    }
}
