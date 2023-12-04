<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use DateTime;
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
    protected MockObject|ConditionalAvailabilityPeriodsFilterInterface $conditionalAvailabilityPeriodsFilterMock;

    protected IndexFinderInterface|MockObject $indexFinderMock;

    protected MessageGeneratorInterface|MockObject $messageGeneratorMock;

    protected DeliveryDateGeneratorInterface|MockObject $deliveryDateGeneratorMock;

    protected ConditionalAvailabilityPeriodsReducerInterface|MockObject $conditionalAvailabilityPeriodsReducerMock;

    protected MockObject|ItemTransfer $itemTransferMock;

    protected MockObject|MessageTransfer $messageTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $conditionalAvailabilityPeriodTransferMocks;

    protected ItemExpanderInterface $expander;

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
                ->getMock(),
        ];

        $this->expander = new ItemExpander(
            $this->conditionalAvailabilityPeriodsFilterMock,
            $this->indexFinderMock,
            $this->messageGeneratorMock,
            $this->deliveryDateGeneratorMock,
            $this->conditionalAvailabilityPeriodsReducerMock,
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliest(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilityPeriodTransfers = new ArrayObject($this->conditionalAvailabilityPeriodTransferMocks);
        $deliveryDate = (new DateTime())->format('Y-m-d');
        $index = 1;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityPeriodsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromGroupedConditionalAvailabilitiesByItem')
            ->with($groupedConditionalAvailabilities, $this->itemTransferMock)
            ->willReturn($conditionalAvailabilityPeriodTransfers);

        $this->messageGeneratorMock->expects(static::never())
            ->method('createNotAvailableForEarliestDeliveryDateMessage');

        $this->indexFinderMock->expects(static::atLeastOnce())
            ->method('findEarliestFromConditionalAvailabilityPeriods')
            ->with($conditionalAvailabilityPeriodTransfers, $this->itemTransferMock)
            ->willReturn($index);

        $this->messageGeneratorMock->expects(static::never())
            ->method('createNotAvailableForGivenQytMessage');

        $this->conditionalAvailabilityPeriodsReducerMock->expects(static::atLeastOnce())
            ->method('reduceByItemAndEffectedIndex')
            ->with($conditionalAvailabilityPeriodTransfers, $this->itemTransferMock, $index)
            ->willReturn($conditionalAvailabilityPeriodTransfers);

        $this->deliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateEarliestByConditionalAvailabilityPeriod')
            ->with($conditionalAvailabilityPeriodTransfers->offsetGet($index))
            ->willReturn($deliveryDate);

        $this->itemTransferMock->expects(static::never())
            ->method('addValidationMessage');

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDate')
            ->with(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE)
            ->willReturn($this->itemTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->with($deliveryDate)
            ->willReturn($this->itemTransferMock);

        static::assertEquals(
            $this->itemTransferMock,
            $this->expander->expand(
                $this->itemTransferMock,
                $groupedConditionalAvailabilities,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestWithoutValidPeriods(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilityPeriodTransfers = new ArrayObject($this->conditionalAvailabilityPeriodTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityPeriodsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromGroupedConditionalAvailabilitiesByItem')
            ->with($groupedConditionalAvailabilities, $this->itemTransferMock)
            ->willReturn($conditionalAvailabilityPeriodTransfers);

        $this->messageGeneratorMock->expects(static::never())
            ->method('createNotAvailableForEarliestDeliveryDateMessage');

        $this->indexFinderMock->expects(static::atLeastOnce())
            ->method('findEarliestFromConditionalAvailabilityPeriods')
            ->with($conditionalAvailabilityPeriodTransfers, $this->itemTransferMock)
            ->willReturn(null);

        $this->messageGeneratorMock->expects(static::atLeastOnce())
            ->method('createNotAvailableForGivenQytMessage')
            ->willReturn($this->messageTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with($this->messageTransferMock)
            ->willReturn($this->itemTransferMock);

        $this->conditionalAvailabilityPeriodsReducerMock->expects(static::never())
            ->method('reduceByItemAndEffectedIndex');

        $this->deliveryDateGeneratorMock->expects(static::never())
            ->method('generateEarliestByConditionalAvailabilityPeriod');

        $this->itemTransferMock->expects(static::never())
            ->method('setDeliveryDate');

        $this->itemTransferMock->expects(static::never())
            ->method('setConcreteDeliveryDate');

        static::assertEquals(
            $this->itemTransferMock,
            $this->expander->expand(
                $this->itemTransferMock,
                $groupedConditionalAvailabilities,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestWithoutPeriods(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityPeriodsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromGroupedConditionalAvailabilitiesByItem')
            ->with($groupedConditionalAvailabilities, $this->itemTransferMock)
            ->willReturn(null);

        $this->messageGeneratorMock->expects(static::atLeastOnce())
            ->method('createNotAvailableForEarliestDeliveryDateMessage')
            ->willReturn($this->messageTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with($this->messageTransferMock)
            ->willReturn($this->itemTransferMock);

        $this->indexFinderMock->expects(static::never())
            ->method('findEarliestFromConditionalAvailabilityPeriods');

        $this->messageGeneratorMock->expects(static::never())
            ->method('createNotAvailableForGivenQytMessage');

        $this->conditionalAvailabilityPeriodsReducerMock->expects(static::never())
            ->method('reduceByItemAndEffectedIndex');

        $this->deliveryDateGeneratorMock->expects(static::never())
            ->method('generateEarliestByConditionalAvailabilityPeriod');

        $this->itemTransferMock->expects(static::never())
            ->method('setDeliveryDate');

        $this->itemTransferMock->expects(static::never())
            ->method('setConcreteDeliveryDate');

        static::assertEquals(
            $this->itemTransferMock,
            $this->expander->expand(
                $this->itemTransferMock,
                $groupedConditionalAvailabilities,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandConcrete(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilityPeriodTransfers = new ArrayObject($this->conditionalAvailabilityPeriodTransferMocks);
        $deliveryDate = (new DateTime())->format('Y-m-d');
        $index = 1;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->conditionalAvailabilityPeriodsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromGroupedConditionalAvailabilitiesByItem')
            ->with($groupedConditionalAvailabilities, $this->itemTransferMock)
            ->willReturn($conditionalAvailabilityPeriodTransfers);

        $this->messageGeneratorMock->expects(static::never())
            ->method('createNotAvailableForGivenDeliveryDateMessage');

        $this->indexFinderMock->expects(static::atLeastOnce())
            ->method('findConcreteFromConditionalAvailabilityPeriods')
            ->with($conditionalAvailabilityPeriodTransfers, $this->itemTransferMock)
            ->willReturn($index);

        $this->messageGeneratorMock->expects(static::never())
            ->method('createNotAvailableForGivenQytMessage');

        $this->conditionalAvailabilityPeriodsReducerMock->expects(static::atLeastOnce())
            ->method('reduceByItemAndEffectedIndex')
            ->with($conditionalAvailabilityPeriodTransfers, $this->itemTransferMock, $index)
            ->willReturn($conditionalAvailabilityPeriodTransfers);

        $this->deliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateConcreteByItem')
            ->with($this->itemTransferMock)
            ->willReturn($deliveryDate);

        $this->itemTransferMock->expects(static::never())
            ->method('addValidationMessage');

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDate')
            ->with($deliveryDate)
            ->willReturn($this->itemTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->with($deliveryDate)
            ->willReturn($this->itemTransferMock);

        static::assertEquals(
            $this->itemTransferMock,
            $this->expander->expand(
                $this->itemTransferMock,
                $groupedConditionalAvailabilities,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandConcreteWithoutValidPeriods(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilityPeriodTransfers = new ArrayObject($this->conditionalAvailabilityPeriodTransferMocks);
        $deliveryDate = (new DateTime())->format('Y-m-d');

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->conditionalAvailabilityPeriodsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromGroupedConditionalAvailabilitiesByItem')
            ->with($groupedConditionalAvailabilities, $this->itemTransferMock)
            ->willReturn($conditionalAvailabilityPeriodTransfers);

        $this->messageGeneratorMock->expects(static::never())
            ->method('createNotAvailableForGivenDeliveryDateMessage');

        $this->indexFinderMock->expects(static::atLeastOnce())
            ->method('findConcreteFromConditionalAvailabilityPeriods')
            ->with($conditionalAvailabilityPeriodTransfers, $this->itemTransferMock)
            ->willReturn(null);

        $this->messageGeneratorMock->expects(static::atLeastOnce())
            ->method('createNotAvailableForGivenQytMessage')
            ->willReturn($this->messageTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with($this->messageTransferMock)
            ->willReturn($this->itemTransferMock);

        $this->conditionalAvailabilityPeriodsReducerMock->expects(static::never())
            ->method('reduceByItemAndEffectedIndex');

        $this->deliveryDateGeneratorMock->expects(static::never())
            ->method('generateConcreteByItem');

        $this->itemTransferMock->expects(static::never())
            ->method('setDeliveryDate');

        $this->itemTransferMock->expects(static::never())
            ->method('setConcreteDeliveryDate');

        static::assertEquals(
            $this->itemTransferMock,
            $this->expander->expand(
                $this->itemTransferMock,
                $groupedConditionalAvailabilities,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandConcreteWithoutPeriods(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject();
        $deliveryDate = (new DateTime())->format('Y-m-d');

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->conditionalAvailabilityPeriodsFilterMock->expects(static::atLeastOnce())
            ->method('filterFromGroupedConditionalAvailabilitiesByItem')
            ->with($groupedConditionalAvailabilities, $this->itemTransferMock)
            ->willReturn(null);

        $this->messageGeneratorMock->expects(static::atLeastOnce())
            ->method('createNotAvailableForGivenDeliveryDateMessage')
            ->willReturn($this->messageTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with($this->messageTransferMock)
            ->willReturn($this->itemTransferMock);

        $this->indexFinderMock->expects(static::never())
            ->method('findConcreteFromConditionalAvailabilityPeriods');

        $this->messageGeneratorMock->expects(static::never())
            ->method('createNotAvailableForGivenQytMessage');

        $this->conditionalAvailabilityPeriodsReducerMock->expects(static::never())
            ->method('reduceByItemAndEffectedIndex');

        $this->deliveryDateGeneratorMock->expects(static::never())
            ->method('generateConcreteByItem');

        $this->itemTransferMock->expects(static::never())
            ->method('setDeliveryDate');

        $this->itemTransferMock->expects(static::never())
            ->method('setConcreteDeliveryDate');

        static::assertEquals(
            $this->itemTransferMock,
            $this->expander->expand(
                $this->itemTransferMock,
                $groupedConditionalAvailabilities,
            ),
        );
    }
}
