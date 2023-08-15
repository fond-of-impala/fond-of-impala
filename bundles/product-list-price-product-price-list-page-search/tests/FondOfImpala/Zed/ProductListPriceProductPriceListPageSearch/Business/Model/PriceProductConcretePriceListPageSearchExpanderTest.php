<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Generated\Shared\Transfer\ProductListMapTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductConcretePriceListPageSearchExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeInterface
     */
    protected MockObject|ProductListPriceProductPriceListPageSearchToProductListFacadeInterface $productListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected MockObject|PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductListMapTransfer
     */
    protected MockObject|ProductListMapTransfer $productListMapTransferMock;

    /**
     * @var int
     */
    protected int $idProduct;

    /**
     * @var int[]
     */
    protected array $whitelistIds;

    /**
     * @var int[]
     */
    protected array $blacklistIds;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductPriceListPageSearchExpanderInterface
     */
    protected PriceProductPriceListPageSearchExpanderInterface $priceProductConcretePriceListPageSearchExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListFacadeMock = $this->getMockBuilder(ProductListPriceProductPriceListPageSearchToProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchTransferMock = $this->getMockBuilder(PriceProductPriceListPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListMapTransferMock = $this->getMockBuilder(ProductListMapTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idProduct = 1;

        $this->whitelistIds = [2];

        $this->blacklistIds = [3];

        $this->priceProductConcretePriceListPageSearchExpander = new PriceProductConcretePriceListPageSearchExpander(
            $this->productListFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testExpandWithProductLists(): void
    {
        $this->priceProductPriceListPageSearchTransferMock->expects(self::atLeastOnce())
            ->method('requireIdProduct')
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $this->priceProductPriceListPageSearchTransferMock->expects(self::atLeastOnce())
            ->method('getProductListMap')
            ->willReturn($this->productListMapTransferMock);

        $this->priceProductPriceListPageSearchTransferMock->expects(self::atLeastOnce())
            ->method('getIdProduct')
            ->willReturn($this->idProduct);

        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($this->idProduct)
            ->willReturn($this->whitelistIds);

        $this->productListMapTransferMock->expects(self::atLeastOnce())
            ->method('setWhitelists')
            ->with($this->whitelistIds)
            ->willReturn($this->productListMapTransferMock);

        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($this->idProduct)
            ->willReturn($this->blacklistIds);

        $this->productListMapTransferMock->expects(self::atLeastOnce())
            ->method('setBlacklists')
            ->with($this->blacklistIds)
            ->willReturn($this->productListMapTransferMock);

        self::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->priceProductConcretePriceListPageSearchExpander->expandWithProductLists(
                $this->priceProductPriceListPageSearchTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithProductListsProductListMapNull(): void
    {
        $this->priceProductPriceListPageSearchTransferMock->expects(self::atLeastOnce())
            ->method('requireIdProduct')
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        $this->priceProductPriceListPageSearchTransferMock->expects(self::atLeastOnce())
            ->method('getProductListMap')
            ->willReturnOnConsecutiveCalls(null, $this->productListMapTransferMock, $this->productListMapTransferMock);

        $this->priceProductPriceListPageSearchTransferMock->expects(self::atLeastOnce())
            ->method('getIdProduct')
            ->willReturn($this->idProduct);

        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($this->idProduct)
            ->willReturn($this->whitelistIds);

        $this->productListMapTransferMock->expects(self::atLeastOnce())
            ->method('setWhitelists')
            ->with($this->whitelistIds)
            ->willReturnSelf();

        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($this->idProduct)
            ->willReturn($this->blacklistIds);

        $this->productListMapTransferMock->expects(self::atLeastOnce())
            ->method('setBlacklists')
            ->with($this->blacklistIds)
            ->willReturnSelf();

        self::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->priceProductConcretePriceListPageSearchExpander->expandWithProductLists(
                $this->priceProductPriceListPageSearchTransferMock,
            ),
        );
    }
}
