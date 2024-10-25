<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridge;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeBridge;
use FondOfOryx\Zed\ErpOrder\Business\ErpOrderFacadeInterface;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\ErpOrder\Persistence\ErpOrderQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;

class ErpOrderCancellationRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected MockObject|BundleProxy $bundleProxyMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiDependencyProvider
     */
    protected ErpOrderCancellationRestApiDependencyProvider $dependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfOryx\Zed\ErpOrder\Business\ErpOrderFacadeInterface
     */
    protected MockObject|ErpOrderFacadeInterface $erpOrderFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface
     */
    protected MockObject|ErpOrderCancellationFacadeInterface $erpOrderCancellationFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Locator
     */
    protected MockObject|Locator $locatorMock;

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

        $this->erpOrderFacadeMock = $this->getMockBuilder(ErpOrderFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationFacadeMock = $this->getMockBuilder(ErpOrderCancellationFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new ErpOrderCancellationRestApiDependencyProvider();
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
            ->withConsecutive(['erpOrder'], ['erpOrderCancellation'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->erpOrderFacadeMock,
                $this->erpOrderCancellationFacadeMock,
            );

        $container = $this->dependencyProvider
            ->provideBusinessLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            ErpOrderCancellationRestApiToErpOrderFacadeBridge::class,
            $container[ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER],
        );

        self::assertInstanceOf(
            ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridge::class,
            $container[ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER_CANCELLATION],
        );

        self::assertIsArray($container[ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_REST_FILTER_TO_FILTER_MAPPER_EXPANDER]);

        self::assertIsArray($container[ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_PERMISSION]);
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        $container = $this->dependencyProvider
            ->providePersistenceLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            SpyCustomerQuery::class,
            $container[ErpOrderCancellationRestApiDependencyProvider::QUERY_SPY_CUSTOMER],
        );

        self::assertInstanceOf(
            SpyCompanyUserQuery::class,
            $container[ErpOrderCancellationRestApiDependencyProvider::QUERY_SPY_COMPANY_USER],
        );

        self::assertInstanceOf(
            FoiErpOrderCancellationQuery::class,
            $container[ErpOrderCancellationRestApiDependencyProvider::QUERY_FOI_ERP_ORDER_CANCELLATION],
        );

        self::assertInstanceOf(
            ErpOrderQuery::class,
            $container[ErpOrderCancellationRestApiDependencyProvider::QUERY_FOO_ERP_ORDER],
        );

        self::assertIsArray($container[ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_QUERY_EXPANDER]);

    }

    /**
     * @return void
     */
    public function testProvideCommunicationLayerDependencies(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('erpOrder')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturn($this->erpOrderFacadeMock);

        $container = $this->dependencyProvider
            ->provideCommunicationLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            ErpOrderCancellationRestApiToErpOrderFacadeBridge::class,
            $container[ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER],
        );
    }


}
