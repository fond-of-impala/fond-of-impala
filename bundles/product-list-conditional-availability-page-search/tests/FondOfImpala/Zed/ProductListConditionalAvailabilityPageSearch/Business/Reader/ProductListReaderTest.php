<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListReaderTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface|MockObject $productListFacadeMock;

    protected ProductListReader $productListReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productListFacadeMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListReader = new ProductListReader(
            $this->productListFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetWhitelistIdsByIdProduct(): void
    {
        $idProduct = 1;
        $whitelistIds = [2, 3, 6];

        $this->productListFacadeMock->expects(static::atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($idProduct)
            ->willReturn($whitelistIds);

        static::assertEquals(
            $whitelistIds,
            $this->productListReader->getWhitelistIdsByIdProduct($idProduct),
        );
    }

    /**
     * @depends testGetWhitelistIdsByIdProduct
     *
     * @return void
     */
    public function testGetWhitelistIdsByIdProductWithCache(): void
    {
        $idProduct = 1;
        $whitelistIds = [2, 3, 6];

        $this->productListFacadeMock->expects(static::never())
            ->method('getProductWhitelistIdsByIdProduct');

        static::assertEquals(
            $whitelistIds,
            $this->productListReader->getWhitelistIdsByIdProduct($idProduct),
        );
    }

    /**
     * @return void
     */
    public function testGetBlacklistIdsByIdProduct(): void
    {
        $idProduct = 1;
        $whitelistIds = [2, 3, 6];

        $this->productListFacadeMock->expects(static::atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($idProduct)
            ->willReturn($whitelistIds);

        static::assertEquals(
            $whitelistIds,
            $this->productListReader->getBlacklistIdsByIdProduct($idProduct),
        );
    }

    /**
     * @depends testGetBlacklistIdsByIdProduct
     *
     * @return void
     */
    public function testGetBlacklistIdsByIdProductWithCache(): void
    {
        $idProduct = 1;
        $whitelistIds = [2, 3, 6];

        $this->productListFacadeMock->expects(static::never())
            ->method('getProductBlacklistIdsByIdProduct');

        static::assertEquals(
            $whitelistIds,
            $this->productListReader->getBlacklistIdsByIdProduct($idProduct),
        );
    }
}
