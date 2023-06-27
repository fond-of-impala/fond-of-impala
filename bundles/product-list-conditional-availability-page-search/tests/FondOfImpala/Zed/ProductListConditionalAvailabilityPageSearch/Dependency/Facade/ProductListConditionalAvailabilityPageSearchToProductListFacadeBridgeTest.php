<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;

class ProductListConditionalAvailabilityPageSearchToProductListFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeBridge
     */
    protected ProductListConditionalAvailabilityPageSearchToProductListFacadeBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    protected MockObject|ProductListFacadeInterface $facadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ProductListConditionalAvailabilityPageSearchToProductListFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetProductWhitelistIdsByIdProduct(): void
    {
        $idProduct = 1;
        $this->facadeMock->expects($this->atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($idProduct)
            ->willReturn([]);

        static::assertEquals([], $this->bridge->getProductWhitelistIdsByIdProduct($idProduct));
    }

    /**
     * @return void
     */
    public function testGetProductBlacklistIdsByIdProduct(): void
    {
        $idProduct = 1;
        $this->facadeMock->expects($this->atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($idProduct)
            ->willReturn([]);

        static::assertEquals([], $this->bridge->getProductBlacklistIdsByIdProduct($idProduct));
    }
}
