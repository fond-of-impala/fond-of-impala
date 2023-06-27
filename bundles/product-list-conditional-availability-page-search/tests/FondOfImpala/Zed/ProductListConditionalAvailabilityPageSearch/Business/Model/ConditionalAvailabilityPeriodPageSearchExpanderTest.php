<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Generated\Shared\Transfer\ProductListMapTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodPageSearchExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpander
     */
    protected ConditionalAvailabilityPeriodPageSearchExpander $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface
     */
    protected MockObject|ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface $productListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected MockObject|ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductListMapTransfer
     */
    protected MockObject|ProductListMapTransfer $productListMapTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListFacadeMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListMapTransferMock = $this->getMockBuilder(ProductListMapTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ConditionalAvailabilityPeriodPageSearchExpander(
            $this->productListFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testExpandWithProductLists(): void
    {
        $fkProduct = 1;
        $whitelistIds = [2];
        $blacklistIds = [3];

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('requireFkProduct')
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getProductListMap')
            ->willReturn($this->productListMapTransferMock);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($fkProduct);

        $this->productListFacadeMock->expects($this->atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($fkProduct)
            ->willReturn($whitelistIds);

        $this->productListMapTransferMock->expects($this->atLeastOnce())
            ->method('setWhitelists')
            ->with($whitelistIds)
            ->willReturnSelf();

        $this->productListFacadeMock->expects($this->atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($fkProduct)
            ->willReturn($blacklistIds);

        $this->productListMapTransferMock->expects($this->atLeastOnce())
            ->method('setBlacklists')
            ->with($blacklistIds)
            ->willReturnSelf();

        static::assertEquals(
            $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            $this->expander->expandWithProductLists(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithProductListsProductListMapNull(): void
    {
        $fkProduct = 1;
        $whitelistIds = [2];
        $blacklistIds = [3];

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('requireFkProduct')
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getProductListMap')
            ->willReturnOnConsecutiveCalls(null, $this->productListMapTransferMock, $this->productListMapTransferMock);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects($this->atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($fkProduct);

        $this->productListFacadeMock->expects($this->atLeastOnce())
            ->method('getProductWhitelistIdsByIdProduct')
            ->with($fkProduct)
            ->willReturn($whitelistIds);

        $this->productListMapTransferMock->expects($this->atLeastOnce())
            ->method('setWhitelists')
            ->with($whitelistIds)
            ->willReturnSelf();

        $this->productListFacadeMock->expects($this->atLeastOnce())
            ->method('getProductBlacklistIdsByIdProduct')
            ->with($fkProduct)
            ->willReturn($blacklistIds);

        $this->productListMapTransferMock->expects($this->atLeastOnce())
            ->method('setBlacklists')
            ->with($blacklistIds)
            ->willReturnSelf();

        static::assertEquals(
            $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            $this->expander->expandWithProductLists(
                $this->conditionalAvailabilityPeriodPageSearchTransferMock,
            ),
        );
    }
}
