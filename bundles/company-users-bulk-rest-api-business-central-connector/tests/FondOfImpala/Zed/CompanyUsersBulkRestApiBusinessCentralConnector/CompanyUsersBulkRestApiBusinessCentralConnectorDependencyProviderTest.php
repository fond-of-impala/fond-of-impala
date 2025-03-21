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
        $containerMock = $this->getMockBuilder(Container::class);

        /** @phpstan-ignore-next-line */
        if (method_exists($containerMock, 'setMethodsExcept')) {
            /** @phpstan-ignore-next-line */
            $containerMock->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet']);
        } else {
            /** @phpstan-ignore-next-line */
            $containerMock->onlyMethods(['getLocator'])->enableOriginalClone();
        }

        $this->containerMock = $containerMock->getMock();

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
