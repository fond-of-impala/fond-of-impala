<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnitQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Permission\Persistence\SpyPermissionQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;

class CompanyUsersBulkRestApiDependencyProviderTest extends Unit
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
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EventFacadeInterface|MockObject $eventFacadeMock;

    /**
     * @var \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiDependencyProvider
     */
    protected CompanyUsersBulkRestApiDependencyProvider $dependencyProvider;

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

        $this->eventFacadeMock = $this->getMockBuilder(EventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new CompanyUsersBulkRestApiDependencyProvider();
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
            ->withConsecutive(['companyUser'], ['event'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->withConsecutive(['facade'])
            ->willReturnOnConsecutiveCalls(
                $this->companyUserFacadeMock,
                $this->eventFacadeMock,
            );

        $container = $this->dependencyProvider->provideBusinessLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        static::assertInstanceOf(
            CompanyUsersBulkRestApiToCompanyUserFacadeInterface::class,
            $container[CompanyUsersBulkRestApiDependencyProvider::FACADE_COMPANY_USER],
        );

        static::assertInstanceOf(
            CompanyUsersBulkRestApiToEventFacadeInterface::class,
            $container[CompanyUsersBulkRestApiDependencyProvider::FACADE_EVENT],
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
            SpyCustomerQuery::class,
            $container[CompanyUsersBulkRestApiDependencyProvider::QUERY_SPY_CUSTOMER],
        );

        static::assertInstanceOf(
            SpyCompanyUserQuery::class,
            $container[CompanyUsersBulkRestApiDependencyProvider::QUERY_SPY_COMPANY_USER],
        );

        static::assertInstanceOf(
            SpyCompanyQuery::class,
            $container[CompanyUsersBulkRestApiDependencyProvider::QUERY_SPY_COMPANY],
        );

        static::assertInstanceOf(
            SpyPermissionQuery::class,
            $container[CompanyUsersBulkRestApiDependencyProvider::PROPEL_QUERY_PERMISSION],
        );

        static::assertInstanceOf(
            SpyCompanyBusinessUnitQuery::class,
            $container[CompanyUsersBulkRestApiDependencyProvider::QUERY_SPY_COMPANY_BUSINESS_UNIT],
        );

        static::assertInstanceOf(
            SpyCompanyRoleQuery::class,
            $container[CompanyUsersBulkRestApiDependencyProvider::QUERY_SPY_COMPANY_ROLE],
        );
    }
}
