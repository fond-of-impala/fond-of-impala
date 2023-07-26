<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector;

use Codeception\Test\Unit;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CompanyUsersBulkRestApiBusinessCentralConnectorDependencyProviderTest extends Unit
{
    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Container|MockObject $containerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\CompanyUsersBulkRestApiBusinessCentralConnectorDependencyProvider
     */
    protected CompanyUsersBulkRestApiBusinessCentralConnectorDependencyProvider $dependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->dependencyProvider = new CompanyUsersBulkRestApiBusinessCentralConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        $container = $this->dependencyProvider->providePersistenceLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        static::assertInstanceOf(
            SpyCompanyQuery::class,
            $container[CompanyUsersBulkRestApiBusinessCentralConnectorDependencyProvider::QUERY_SPY_COMPANY],
        );
    }
}
