<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityDeliveryDateCleanerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleaner
     */
    protected $conditionalAvailabilityDeliveryDateCleaner;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \ArrayObject<\Generated\Shared\Transfer\ItemTransfer>
     */
    protected $itemTransferMocks;

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

        $this->itemTransferMocks = new ArrayObject([
           $this->itemTransferMock,
        ]);

        $this->conditionalAvailabilityDeliveryDateCleaner = new ConditionalAvailabilityDeliveryDateCleaner();
    }

    /**
     * @return void
     */
    public function testCleanDeliveryDate(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->assertInstanceOf(
            QuoteTransfer::class,
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
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([]));

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->conditionalAvailabilityDeliveryDateCleaner->cleanDeliveryDate(
                $this->quoteTransferMock,
            ),
        );
    }
}
