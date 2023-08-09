<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeInterface;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Generated\Shared\Transfer\ProductListMapTransfer;

class PriceProductAbstractPriceListPageSearchExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeInterface
     */
    protected $productListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected $priceProductPriceListPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductListMapTransfer
     */
    protected $productListMapTransferMock;

    /**
     * @var int
     */
    protected $idProductAbstract;

    /**
     * @var int[]
     */
    protected $whitelistIds;

    /**
     * @var int[]
     */
    protected $blacklistIds;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductPriceListPageSearchExpanderInterface
     */
    protected $priceProductAbstractPriceListPageSearchExpander;

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

        $this->idProductAbstract = 1;

        $this->whitelistIds = [2];

        $this->blacklistIds = [3];

        $this->priceProductAbstractPriceListPageSearchExpander = new PriceProductAbstractPriceListPageSearchExpander(
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
            ->willReturn($this->idProductAbstract);

        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductWhitelistIdsByIdProductAbstract')
            ->with($this->idProductAbstract)
            ->willReturn($this->whitelistIds);

        $this->productListMapTransferMock->expects(self::atLeastOnce())
            ->method('setWhitelists')
            ->with($this->whitelistIds)
            ->willReturn($this->productListMapTransferMock);

        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductBlacklistIdsByIdProductAbstract')
            ->with($this->idProductAbstract)
            ->willReturn($this->blacklistIds);

        $this->productListMapTransferMock->expects(self::atLeastOnce())
            ->method('setBlacklists')
            ->with($this->blacklistIds)
            ->willReturn($this->productListMapTransferMock);

        self::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->priceProductAbstractPriceListPageSearchExpander->expandWithProductLists(
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
            ->willReturn($this->idProductAbstract);

        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductWhitelistIdsByIdProductAbstract')
            ->with($this->idProductAbstract)
            ->willReturn($this->whitelistIds);

        $this->productListMapTransferMock->expects(self::atLeastOnce())
            ->method('setWhitelists')
            ->with($this->whitelistIds)
            ->willReturnSelf();

        $this->productListFacadeMock->expects(self::atLeastOnce())
            ->method('getProductBlacklistIdsByIdProductAbstract')
            ->with($this->idProductAbstract)
            ->willReturn($this->blacklistIds);

        $this->productListMapTransferMock->expects(self::atLeastOnce())
            ->method('setBlacklists')
            ->with($this->blacklistIds)
            ->willReturnSelf();

        self::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->priceProductAbstractPriceListPageSearchExpander->expandWithProductLists(
                $this->priceProductPriceListPageSearchTransferMock,
            ),
        );
    }
}
