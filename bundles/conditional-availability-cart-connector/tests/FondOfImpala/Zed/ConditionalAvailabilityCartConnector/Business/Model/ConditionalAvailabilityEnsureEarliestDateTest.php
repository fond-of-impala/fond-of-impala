<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityEnsureEarliestDateTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDate
     */
    protected ConditionalAvailabilityEnsureEarliestDate $conditionalAvailabilityEnsureEarliestDate;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityEnsureEarliestDate = new ConditionalAvailabilityEnsureEarliestDate();
    }

    /**
     * @return void
     */
    public function testEnsureEarliestDate(): void
    {
        $deliveryDates = [
            '...',
        ];
        $countOfDeliveryDates = count($deliveryDates);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDates')
            ->willReturn($deliveryDates);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with(
                static::callback(
                    static fn (
                        array $currentDeliveryDates
                    ): bool => count($currentDeliveryDates) === ($countOfDeliveryDates + 1)
                        && $currentDeliveryDates[$countOfDeliveryDates] === ConditionalAvailabilityConstants::KEY_EARLIEST_DATE,
                ),
            )->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
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
        $deliveryDates = [
            ConditionalAvailabilityConstants::KEY_EARLIEST_DATE,
        ];

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDates')
            ->willReturn($deliveryDates);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityEnsureEarliestDate->ensureEarliestDate(
                $this->quoteTransferMock,
            ),
        );
    }
}
