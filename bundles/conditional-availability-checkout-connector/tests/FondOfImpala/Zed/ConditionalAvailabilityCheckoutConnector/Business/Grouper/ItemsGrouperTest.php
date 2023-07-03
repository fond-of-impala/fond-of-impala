<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ItemsGrouperTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper\ItemsGrouper
     */
    protected ItemsGrouper $itemsGrouper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemsGrouper = new ItemsGrouper();
    }

    /**
     * @return void
     */
    public function testGroup(): void
    {
        $sku = 'foo';

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $groupedItemTransfers = $this->itemsGrouper->group($this->quoteTransferMock);

        static::assertArrayHasKey($sku, $groupedItemTransfers);
        static::assertCount(1, $groupedItemTransfers->offsetGet($sku));
        static::assertEquals($this->itemTransferMock, $groupedItemTransfers->offsetGet($sku)->offsetGet(0));
    }
}
