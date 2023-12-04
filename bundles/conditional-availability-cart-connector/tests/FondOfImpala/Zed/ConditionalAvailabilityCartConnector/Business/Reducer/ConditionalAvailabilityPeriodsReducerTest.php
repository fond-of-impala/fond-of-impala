<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodsReducerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>
     */
    protected array $conditionalAvailabilityPeriodTransferMocks;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducer
     */
    protected ConditionalAvailabilityPeriodsReducer $reducer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMocks = [
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->reducer = new ConditionalAvailabilityPeriodsReducer();
    }

    /**
     * @return void
     */
    public function testReduceByItemAndEffectedIndex(): void
    {
        $conditionalAvailabilityPeriodTransfers = new ArrayObject($this->conditionalAvailabilityPeriodTransferMocks);
        $effectedIndex = 2;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(2);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(1);

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(2);

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(3);

        $this->conditionalAvailabilityPeriodTransferMocks[3]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(5);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::never())
            ->method('setQuantity');

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(1);

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(1);

        $this->conditionalAvailabilityPeriodTransferMocks[3]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(3);

        static::assertEquals(
            $conditionalAvailabilityPeriodTransfers,
            $this->reducer->reduceByItemAndEffectedIndex(
                $conditionalAvailabilityPeriodTransfers,
                $this->itemTransferMock,
                $effectedIndex,
            ),
        );
    }
}
