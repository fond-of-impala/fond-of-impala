<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductAbstractPriceListPageSearchExpander;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductConcretePriceListPageSearchExpander;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeInterface;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchDependencyProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ProductListPriceProductPriceListPageSearchBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeInterface
     */
    protected MockObject|ProductListPriceProductPriceListPageSearchToProductListFacadeInterface $productListFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchBusinessFactory
     */
    protected ProductListPriceProductPriceListPageSearchBusinessFactory $productListPriceProductPriceListPageSearchBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListFacadeMock = $this->getMockBuilder(ProductListPriceProductPriceListPageSearchToProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductPriceListPageSearchBusinessFactory = new ProductListPriceProductPriceListPageSearchBusinessFactory();
        $this->productListPriceProductPriceListPageSearchBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreatePriceProductAbstractPriceListPageSearchExpander(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(self::atLeastOnce())
            ->method('get')
            ->with(ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_PRODUCT_LIST)
            ->willReturn($this->productListFacadeMock);

        self::assertInstanceOf(
            PriceProductAbstractPriceListPageSearchExpander::class,
            $this->productListPriceProductPriceListPageSearchBusinessFactory->createPriceProductAbstractPriceListPageSearchExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreatePriceProductConcretePriceListPageSearchExpander(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(self::atLeastOnce())
            ->method('get')
            ->with(ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_PRODUCT_LIST)
            ->willReturn($this->productListFacadeMock);

        self::assertInstanceOf(
            PriceProductConcretePriceListPageSearchExpander::class,
            $this->productListPriceProductPriceListPageSearchBusinessFactory->createPriceProductConcretePriceListPageSearchExpander(),
        );
    }
}
