<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodsFilterTest extends Unit
{
    protected ConditionalAvailabilityTransfer|MockObject $conditionalAvailabilityTransferMock;

    protected MockObject|ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransferMock;

    protected ConditionalAvailabilityPeriodTransfer|MockObject $conditionalAvailabilityPeriodTransferMock;

    protected MockObject|ItemTransfer $itemTransferMock;

    protected ConditionalAvailabilityPeriodsFilter $filter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->filter = new ConditionalAvailabilityPeriodsFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromGroupedConditionalAvailabilitiesByItem(): void
    {
        $sku = 'foo';

        /** @var \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities */
        $groupedConditionalAvailabilities = new ArrayObject([
            $sku => new ArrayObject([
                $this->conditionalAvailabilityTransferMock,
            ]),
        ]);

        $conditionalAvailabilityPeriodTransfers = new ArrayObject([
            $this->conditionalAvailabilityPeriodTransferMock,
        ]);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($conditionalAvailabilityPeriodTransfers);

        static::assertEquals(
            $conditionalAvailabilityPeriodTransfers,
            $this->filter->filterFromGroupedConditionalAvailabilitiesByItem(
                $groupedConditionalAvailabilities,
                $this->itemTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromGroupedConditionalAvailabilitiesByItemWithInvalidSku(): void
    {
        $sku = 'foo';

        /** @var \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities */
        $groupedConditionalAvailabilities = new ArrayObject([
            'bar' => new ArrayObject([
                $this->conditionalAvailabilityTransferMock,
            ]),
        ]);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityTransferMock->expects(static::never())
            ->method('getConditionalAvailabilityPeriodCollection');

        static::assertEquals(
            null,
            $this->filter->filterFromGroupedConditionalAvailabilitiesByItem(
                $groupedConditionalAvailabilities,
                $this->itemTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromGroupedConditionalAvailabilitiesByItemWithoutResult(): void
    {
        $sku = 'foo';

        /** @var \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities */
        $groupedConditionalAvailabilities = new ArrayObject([
            $sku => new ArrayObject([
                $this->conditionalAvailabilityTransferMock,
            ]),
        ]);

        $conditionalAvailabilityPeriodTransfers = new ArrayObject([
            $this->conditionalAvailabilityPeriodTransferMock,
        ]);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        static::assertEquals(
            null,
            $this->filter->filterFromGroupedConditionalAvailabilitiesByItem(
                $groupedConditionalAvailabilities,
                $this->itemTransferMock,
            ),
        );
    }
}
