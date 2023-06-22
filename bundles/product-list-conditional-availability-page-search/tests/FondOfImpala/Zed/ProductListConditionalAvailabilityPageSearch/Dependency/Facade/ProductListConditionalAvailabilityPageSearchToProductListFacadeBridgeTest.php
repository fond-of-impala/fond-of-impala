<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;

class ProductListConditionalAvailabilityPageSearchToProductListFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeBridge
     */
    protected $productListConditionalAvailabilityPageSearchToProductListFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    protected $productListFacadeInterfaceMock;

    /**
     * @var int
     */
    protected $idProduct;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListFacadeInterfaceMock = $this->getMockBuilder(ProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idProduct = 1;

        $this->productListConditionalAvailabilityPageSearchToProductListFacadeBridge = new ProductListConditionalAvailabilityPageSearchToProductListFacadeBridge(
            $this->productListFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetProductWhitelistIdsByIdProduct(): void
    {
        $this->productListFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($this->idProduct)
            ->willReturn([]);

        $this->assertIsArray(
            $this->productListConditionalAvailabilityPageSearchToProductListFacadeBridge->getProductWhitelistIdsByIdProduct(
                $this->idProduct,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetProductBlacklistIdsByIdProduct(): void
    {
        $this->productListFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($this->idProduct)
            ->willReturn([]);

        $this->assertIsArray(
            $this->productListConditionalAvailabilityPageSearchToProductListFacadeBridge->getProductBlacklistIdsByIdProduct(
                $this->idProduct,
            ),
        );
    }
}
