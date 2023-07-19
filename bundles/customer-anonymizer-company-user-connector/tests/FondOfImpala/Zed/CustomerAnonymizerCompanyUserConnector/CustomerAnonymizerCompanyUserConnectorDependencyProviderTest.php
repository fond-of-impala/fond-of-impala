<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;

class CustomerAnonymizerCompanyUserConnectorDependencyProviderTest extends Unit
{
    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Container|MockObject $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Locator
     */
    protected MockObject|Locator $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected MockObject|BundleProxy $bundleProxyMock;

    /**
     * @var \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EventFacadeInterface|MockObject $eventFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorDependencyProvider
     */
    protected CustomerAnonymizerCompanyUserConnectorDependencyProvider $dependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this->getMockBuilder(EventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new CustomerAnonymizerCompanyUserConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(static::atLeastOnce())
            ->method('__call')
            ->withConsecutive(['companyUser'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->withConsecutive(['facade'], ['facade'])
            ->willReturnOnConsecutiveCalls(
                $this->companyUserFacadeMock,
                $this->eventFacadeMock,
            );

        $container = $this->dependencyProvider->provideBusinessLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        static::assertInstanceOf(
            CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface::class,
            $container[CustomerAnonymizerCompanyUserConnectorDependencyProvider::FACADE_COMPANY_USER],
        );

        static::assertInstanceOf(
            CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface::class,
            $container[CustomerAnonymizerCompanyUserConnectorDependencyProvider::FACADE_EVENT],
        );
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        $container = $this->dependencyProvider->providePersistenceLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        static::assertInstanceOf(
            SpyCompanyUserQuery::class,
            $container[CustomerAnonymizerCompanyUserConnectorDependencyProvider::QUERY_COMPANY_USER],
        );
    }
}
