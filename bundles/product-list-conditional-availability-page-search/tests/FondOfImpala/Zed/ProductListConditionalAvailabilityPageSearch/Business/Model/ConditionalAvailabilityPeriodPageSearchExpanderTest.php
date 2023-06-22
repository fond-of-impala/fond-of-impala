<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Generated\Shared\Transfer\ProductListMapTransfer;

class ConditionalAvailabilityPeriodPageSearchExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpander
     */
    protected $conditionalAvailabilityPeriodPageSearchExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface
     */
    protected $productListConditionalAvailabilityPageSearchToProductListFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected $conditionalAvailabilityPeriodPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductListMapTransfer
     */
    protected $productListMapTransferMock;

    /**
     * @var int
     */
    protected $fkProduct;

    /**
     * @var array<int>
     */
    protected $whitelistIds;

    /**
     * @var array<int>
     */
    protected $blacklistIds;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListConditionalAvailabilityPageSearchToProductListFacadeInterfaceMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListMapTransferMock = $this->getMockBuilder(ProductListMapTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fkProduct = 1;

        $this->whitelistIds = [2];

        $this->blacklistIds = [3];

        $this->conditionalAvailabilityPeriodPageSearchExpander = new ConditionalAvailabilityPeriodPageSearchExpander(
            $this->productListConditionalAvailabilityPageSearchToProductListFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testExpandWithProductLists(): void
    {
        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('requireFkProduct')
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getProductListMap')
            ->willReturn($this->productListMapTransferMock);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($this->fkProduct);

        $this->productListConditionalAvailabilityPageSearchToProductListFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($this->fkProduct)
            ->willReturn($this->whitelistIds);

        $this->productListMapTransferMock->expects($this->atLeastOnce())
            ->method('setWhitelists')
            ->with($this->whitelistIds)
            ->willReturnSelf();

        $this->productListConditionalAvailabilityPageSearchToProductListFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($this->fkProduct)
            ->willReturn($this->blacklistIds);

        $this->productListMapTransferMock->expects($this->atLeastOnce())
            ->method('setBlacklists')
            ->with($this->blacklistIds)
            ->willReturnSelf();

        $this->assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchTransfer::class,
            $this->conditionalAvailabilityPeriodPageSearchExpander->expandWithProductLists(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithProductListsProductListMapNull(): void
    {
        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('requireFkProduct')
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getProductListMap')
            ->willReturnOnConsecutiveCalls(null, $this->productListMapTransferMock, $this->productListMapTransferMock);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($this->fkProduct);

        $this->productListConditionalAvailabilityPageSearchToProductListFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($this->fkProduct)
            ->willReturn($this->whitelistIds);

        $this->productListMapTransferMock->expects($this->atLeastOnce())
            ->method('setWhitelists')
            ->with($this->whitelistIds)
            ->willReturnSelf();

        $this->productListConditionalAvailabilityPageSearchToProductListFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($this->fkProduct)
            ->willReturn($this->blacklistIds);

        $this->productListMapTransferMock->expects($this->atLeastOnce())
            ->method('setBlacklists')
            ->with($this->blacklistIds)
            ->willReturnSelf();

        $this->assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchTransfer::class,
            $this->conditionalAvailabilityPeriodPageSearchExpander->expandWithProductLists(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }
}
