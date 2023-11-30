<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ItemExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilterInterface
     */
    protected MockObject|ConditionalAvailabilityPeriodsFilterInterface $conditionalAvailabilityPeriodsFilterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer
     */
    protected MockObject|ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinderInterface
     */
    protected IndexFinderInterface|MockObject $indexFinderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface
     */
    protected MessageGeneratorInterface|MockObject $messageGeneratorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface
     */
    protected DeliveryDateGeneratorInterface|MockObject $deliveryDateGeneratorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducerInterface
     */
    protected ConditionalAvailabilityPeriodsReducerInterface|MockObject $conditionalAvailabilityPeriodsReducerMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\ItemExpanderInterface
     */
    protected ItemExpanderInterface $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MessageTransfer
     */
    protected MockObject|MessageTransfer $messageTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityPeriodsFilterMock = $this->getMockBuilder(ConditionalAvailabilityPeriodsFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodMock = $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->indexFinderMock = $this->getMockBuilder(IndexFinderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageGeneratorMock = $this->getMockBuilder(MessageGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->deliveryDateGeneratorMock = $this->getMockBuilder(DeliveryDateGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodsReducerMock = $this->getMockBuilder(ConditionalAvailabilityPeriodsReducerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageTransferMock = $this->getMockBuilder(MessageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMocks = [
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
                ->disableOriginalConstructor()
                ->getMock()
        ];

        $this->expander = new ItemExpander(
            $this->conditionalAvailabilityPeriodsFilterMock,
            $this->indexFinderMock,
            $this->messageGeneratorMock,
            $this->deliveryDateGeneratorMock,
            $this->conditionalAvailabilityPeriodsReducerMock
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilityPeriodTransfers = new ArrayObject();
        $conditionalAvailabilityPeriodTransfers->append($this->conditionalAvailabilityPeriodMock);
        $index = 1;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityPeriodsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromGroupedConditionalAvailabilitiesByItem')
            ->with($groupedConditionalAvailabilities, $this->itemTransferMock)
            ->willReturn($conditionalAvailabilityPeriodTransfers);

        $this->indexFinderMock->expects(static::atLeastOnce())
            ->method('findEarliestFromConditionalAvailabilityPeriods')
            ->with($conditionalAvailabilityPeriodTransfers, $this->itemTransferMock)
            ->willReturn($index);

        $this->conditionalAvailabilityPeriodsReducerMock->expects(static::atLeastOnce())
            ->method('reduceByItemAndEffectedIndex')
            ->with($conditionalAvailabilityPeriodTransfers, $this->itemTransferMock, $index)
            ->willReturn();

        $this->expander->expand(
            $this->itemTransferMock,
            $groupedConditionalAvailabilities
        );
    }

}
