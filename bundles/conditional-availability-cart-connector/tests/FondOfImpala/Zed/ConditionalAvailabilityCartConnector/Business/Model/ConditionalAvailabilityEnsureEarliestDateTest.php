<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityEnsureEarliestDateTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDate
     */
    protected $conditionalAvailabilityEnsureEarliestDate;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var array<string>
     */
    protected $deliveryDates;

    /**
     * @var string
     */
    protected $deliveryDate;

    /**
     * @var array
     */
    protected $deliveryDatesWithEarlistestDeliveryDate;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->deliveryDate = 'delivery-date';

        $this->deliveryDates = [
            $this->deliveryDate,
        ];

        $this->deliveryDatesWithEarlistestDeliveryDate = [
            ConditionalAvailabilityConstants::KEY_EARLIEST_DATE,
        ];

        $this->conditionalAvailabilityEnsureEarliestDate = new ConditionalAvailabilityEnsureEarliestDate();
    }

    /**
     * @return void
     */
    public function testEnsureEarliestDate(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getDeliveryDates')
            ->willReturn($this->deliveryDates);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->conditionalAvailabilityEnsureEarliestDate->ensureEarliestDate(
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testEnsureEarliestDateWithEarliestDeliveryDate(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getDeliveryDates')
            ->willReturn($this->deliveryDatesWithEarlistestDeliveryDate);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->conditionalAvailabilityEnsureEarliestDate->ensureEarliestDate(
                $this->quoteTransferMock,
            ),
        );
    }
}
