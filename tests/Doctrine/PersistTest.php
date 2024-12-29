<?php

declare(strict_types=1);

namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTestCase;
use DoctrineMongoODMModuleTest\Assets\Document\Simple;

class PersistTest extends AbstractTestCase
{
    public function testPersist(): void
    {
        $documentManager = $this->getDocumentManager();

        $simple = new Simple();
        $simple->setName('lucy');

        $documentManager->persist($simple);
        $documentManager->flush();
        $id = $simple->getId();

        $repository = $documentManager->getRepository($simple::class);
        $simple     = $repository->find($id);

        $this->assertEquals('lucy', $simple->getName());
    }
}
