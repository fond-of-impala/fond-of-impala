<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityDeliveryDateCleanerTest extends Unit
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
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleaner
     */
    protected ConditionalAvailabilityDeliveryDateCleaner $conditionalAvailabilityDeliveryDateCleaner;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityDeliveryDateCleaner = new ConditionalAvailabilityDeliveryDateCleaner();
    }

    /**
     * @return void
     */
    public function testCleanDeliveryDate(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->quoteTransferMock->expects(static::never())
            ->method('setDeliveryDates');

        $this->quoteTransferMock->expects(static::never())
            ->method('setConcreteDeliveryDates');

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityDeliveryDateCleaner->cleanDeliveryDate(
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCleanDeliveryDateEmptyItems(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([]));

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with(null)
            ->willReturn($this->itemTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with(null)
            ->willReturn($this->itemTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityDeliveryDateCleaner->cleanDeliveryDate(
                $this->quoteTransferMock,
            ),
        );
    }
}
