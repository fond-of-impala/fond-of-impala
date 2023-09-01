<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;

class ProductListPriceProductPriceListPageSearchToProductListFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeBridge
     */
    protected ProductListPriceProductPriceListPageSearchToProductListFacadeBridge $productListPriceProductPriceListPageSearchToProductListFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    protected MockObject|ProductListFacadeInterface $productListFacadeMock;

    /**
     * @var int
     */
    protected int $idProduct;

    /**
     * @var int
     */
    protected int $idProductAbstract;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListFacadeMock = $this->getMockBuilder(ProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idProductAbstract = $this->idProduct = 1;

        $this->productListPriceProductPriceListPageSearchToProductListFacadeBridge = new ProductListPriceProductPriceListPageSearchToProductListFacadeBridge(
            $this->productListFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetProductWhitelistIdsByIdProduct(): void
    {
        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($this->idProduct)
            ->willReturn([]);

        self::assertIsArray(
            $this->productListPriceProductPriceListPageSearchToProductListFacadeBridge->getProductWhitelistIdsByIdProduct(
                $this->idProduct,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetProductBlacklistIdsByIdProduct(): void
    {
        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($this->idProduct)
            ->willReturn([]);

        self::assertIsArray(
            $this->productListPriceProductPriceListPageSearchToProductListFacadeBridge->getProductBlacklistIdsByIdProduct(
                $this->idProduct,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetProductWhitelistIdsByIdProductAbstract(): void
    {
        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductWhitelistIdsByIdProductAbstract')
            ->with($this->idProductAbstract)
            ->willReturn([]);

        self::assertIsArray(
            $this->productListPriceProductPriceListPageSearchToProductListFacadeBridge->getProductWhitelistIdsByIdProductAbstract(
                $this->idProduct,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetProductBlacklistIdsByIdProductAbstract(): void
    {
        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductBlacklistIdsByIdProductAbstract')
            ->with($this->idProductAbstract)
            ->willReturn([]);

        self::assertIsArray(
            $this->productListPriceProductPriceListPageSearchToProductListFacadeBridge->getProductBlacklistIdsByIdProductAbstract(
                $this->idProduct,
            ),
        );
    }
}
