<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Reader\ProductListReaderInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Generated\Shared\Transfer\ProductListMapTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodPageSearchExpanderTest extends Unit
{
    protected ConditionalAvailabilityPeriodPageSearchExpander $expander;

    protected MockObject|ProductListReaderInterface $productListReaderMock;

    protected MockObject|ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransferMock;

    protected MockObject|ProductListMapTransfer $productListMapTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListReaderMock = $this->getMockBuilder(ProductListReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListMapTransferMock = $this->getMockBuilder(ProductListMapTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ConditionalAvailabilityPeriodPageSearchExpander(
            $this->productListReaderMock,
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

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('requireFkProduct')
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getProductListMap')
            ->willReturn($this->productListMapTransferMock);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($fkProduct);

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getWhitelistIdsByIdProduct')
            ->with($fkProduct)
            ->willReturn($whitelistIds);

        $this->productListMapTransferMock->expects(static::atLeastOnce())
            ->method('setWhitelists')
            ->with($whitelistIds)
            ->willReturnSelf();

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getBlacklistIdsByIdProduct')
            ->with($fkProduct)
            ->willReturn($blacklistIds);

        $this->productListMapTransferMock->expects(static::atLeastOnce())
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

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('requireFkProduct')
            ->willReturnSelf();

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getProductListMap')
            ->willReturnOnConsecutiveCalls(null, $this->productListMapTransferMock, $this->productListMapTransferMock);

        $this->conditionalAvailabilityPeriodPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getFkProduct')
            ->willReturn($fkProduct);

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getWhitelistIdsByIdProduct')
            ->with($fkProduct)
            ->willReturn($whitelistIds);

        $this->productListMapTransferMock->expects(static::atLeastOnce())
            ->method('setWhitelists')
            ->with($whitelistIds)
            ->willReturnSelf();

        $this->productListReaderMock->expects(static::atLeastOnce())
            ->method('getBlacklistIdsByIdProduct')
            ->with($fkProduct)
            ->willReturn($blacklistIds);

        $this->productListMapTransferMock->expects(static::atLeastOnce())
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
