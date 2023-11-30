<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use Codeception\Test\Unit;
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
    protected MockObject|ConditionalAvailabilityPeriodsFilterInterface $conditionalAvailabilityPeriodsFilterMock;

    protected IndexFinderInterface|MockObject $indexFinderMock;

    protected MessageGeneratorInterface|MockObject $messageGeneratorMock;

    protected DeliveryDateGeneratorInterface|MockObject $deliveryDateGeneratorMock;

    protected ConditionalAvailabilityPeriodsReducerInterface|MockObject $conditionalAvailabilityPeriodsReducerMock;

    protected MockObject|ItemTransfer $itemTransferMock;

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
        ]

        $this->expander = new ItemExpander(
            $this->conditionalAvailabilityPeriodsFilterMock,
            $this->indexFinderMock,
            $this->messageGeneratorMock,
            $this->deliveryDateGeneratorMock,
            $this->conditionalAvailabilityPeriodsReducerMock
        );
    }

}
