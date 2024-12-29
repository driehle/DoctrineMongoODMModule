<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTestCase;
use DoctrineMongoODMModuleTest\Assets\CustomDocumentRepository;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;

use function assert;

final class CustomDefaultRepositoryTest extends AbstractTestCase
{
    public function testCustomDefaultRepository(): void
    {
        $documentManager = $this->getDocumentManager();

        $repository = $documentManager->getRepository(Simple::class);

        $this->assertInstanceOf(CustomDocumentRepository::class, $repository);
        assert($repository instanceof CustomDocumentRepository);
        $this->assertTrue($repository->isCustomDefaultDocumentRepository());
    }
}
