<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ProductListPriceProductPriceListPageSearchToProductFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected MockObject|ProductFacadeInterface $productFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductFacadeBridge
     */
    protected ProductListPriceProductPriceListPageSearchToProductFacadeBridge $productListPriceProductPriceListPageSearchToProductFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productFacadeMock = $this->getMockBuilder(ProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductPriceListPageSearchToProductFacadeBridge = new ProductListPriceProductPriceListPageSearchToProductFacadeBridge(
            $this->productFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetProductAbstractIdsByProductConcreteIds(): void
    {
        $productConcreteIds = [2, 4, 6];
        $expectedProductAbstractIds = [1, 3, 5];

        $this->productFacadeMock->expects(self::atLeastOnce())
            ->method('getProductAbstractIdsByProductConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($expectedProductAbstractIds);

        $productAbstractIds = $this->productListPriceProductPriceListPageSearchToProductFacadeBridge
            ->getProductAbstractIdsByProductConcreteIds(
                $productConcreteIds,
            );

        self::assertEquals($expectedProductAbstractIds, $productAbstractIds);
    }
}
