<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeBridge;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductFacadeBridge;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeBridge;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Product\Business\ProductFacadeInterface;
use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;

class ProductListPriceProductPriceListPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Locator
     */
    protected $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected $eventBehaviorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface
     */
    protected $priceProductPriceListPageSearchFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected $productFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    protected $productListFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchDependencyProvider
     */
    protected $productListPriceProductPriceListPageSearchDependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(EventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchFacadeMock = $this->getMockBuilder(PriceProductPriceListPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productFacadeMock = $this->getMockBuilder(ProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListFacadeMock = $this->getMockBuilder(ProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductPriceListPageSearchDependencyProvider = new ProductListPriceProductPriceListPageSearchDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(self::atLeastOnce())
            ->method('__call')
            ->with('productList')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(self::atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturn($this->productListFacadeMock);

        $container = $this->productListPriceProductPriceListPageSearchDependencyProvider->provideBusinessLayerDependencies(
            $this->containerMock,
        );

        self::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            ProductListPriceProductPriceListPageSearchToProductListFacadeBridge::class,
            $container[ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_PRODUCT_LIST],
        );
    }

    /**
     * @return void
     */
    public function testProvideCommunicationLayerDependencies(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(self::atLeastOnce())
            ->method('__call')
            ->withConsecutive(['eventBehavior'], ['priceProductPriceListPageSearch'], ['product'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(self::atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->eventBehaviorFacadeMock,
                $this->priceProductPriceListPageSearchFacadeMock,
                $this->productFacadeMock,
            );

        $container = $this->productListPriceProductPriceListPageSearchDependencyProvider->provideCommunicationLayerDependencies(
            $this->containerMock,
        );

        self::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            ProductListPriceProductPriceListPageSearchToEventBehaviorFacadeBridge::class,
            $container[ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR],
        );

        self::assertInstanceOf(
            ProductListPriceProductPriceListPageSearchToPriceProductPriceListPageSearchFacadeBridge::class,
            $container[ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH],
        );

        self::assertInstanceOf(
            ProductListPriceProductPriceListPageSearchToProductFacadeBridge::class,
            $container[ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_PRODUCT],
        );
    }
}
