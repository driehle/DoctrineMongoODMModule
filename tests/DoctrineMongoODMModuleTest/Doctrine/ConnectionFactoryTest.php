<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */
namespace DoctrineMongoODMModuleTest\Service;

use DoctrineMongoODMModule\Service\ConnectionFactory;
use DoctrineMongoODMModuleTest\AbstractTest;

/**
 * Class ConnectionFactoryTest
 *
 * @author  Hennadiy Verkh <hv@verkh.de>
 * @covers  \DoctrineMongoODMModule\Service\ConnectionFactory
 */
class ConnectionFactoryTest extends AbstractTest
{
    private $configuration = array();

    private $connectionFactory = array();

    public function setup()
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->configuration     = $this->serviceManager->get('Configuration');
        $this->connectionFactory = new ConnectionFactory('odm_default');
    }

    public function testConnectionStringOverwritesOtherConnectionSettings()
    {
        $connectionString = 'mongodb://localhost:27017';
        $connectionConfig = array(
            'odm_default' => array(
                'server'           => 'unreachable',
                'port'             => '10000',
                'connectionString' => $connectionString,
                'user'             => 'test fails if used',
                'password'         => 'test fails if used',
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowMultipleHosts()
    {
        $unreachablePort  = 56000;
        $connectionString = "mongodb://localhost:$unreachablePort,localhost:27017";
        $connectionConfig = array(
            'odm_default' => array(
                'connectionString' => $connectionString,
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testConnectionStringShouldAllowUnixSockets()
    {
        $connectionString = 'mongodb:///tmp/mongodb-27017.sock';
        $connectionConfig = array(
            'odm_default' => array(
                'connectionString' => $connectionString,
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->getServer());
    }

    public function testDbNameShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionConfig = array(
            'odm_default' => array(
                'dbname' => $dbName,
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testDbNameShouldNotOverrideExplicitDefaultDB()
    {
        $defaultDB  = 'foo_db';
        $connectionConfig = array(
            'odm_default' => array(
                'dbname' => 'test fails if this is defaultDB',
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB($defaultDB);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($defaultDB, $configuration->getDefaultDB());
    }

    public function testConnectionStringShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionString = "mongodb://localhost:27017/$dbName";
        $connectionConfig = array(
            'odm_default' => array(
                'connectionString' => $connectionString,
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testConnectionStringWithOptionsShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionString = "mongodb://localhost:27017/$dbName";
        $connectionConfig = array(
            'odm_default' => array(
                'connectionString' => $connectionString,
            )
        );

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('Configuration', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB(null);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }
}
