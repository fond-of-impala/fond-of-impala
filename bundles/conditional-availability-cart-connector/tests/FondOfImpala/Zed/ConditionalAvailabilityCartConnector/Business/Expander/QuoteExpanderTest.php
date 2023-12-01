<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use DateInterval;
use DateTime;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class QuoteExpanderTest extends Unit
{
    protected MockObject|ConditionalAvailabilityReaderInterface $conditionalAvailabilityReaderMock;

    protected MockObject|ItemExpanderInterface $itemExpanderMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $itemTransferMocks;

    protected QuoteExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityReaderMock = $this->getMockBuilder(ConditionalAvailabilityReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemExpanderMock = $this->getMockBuilder(ItemExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = [
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->expander = new QuoteExpander(
            $this->conditionalAvailabilityReaderMock,
            $this->itemExpanderMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject();

        $deliveryDates = [
            (new DateTime())->format('Y-m-d'),
            'earliest',
        ];

        $concreteDeliveryDates = [
            null,
            (new DateTime())->add(new DateInterval('P10D'))->format('Y-m-d'),
        ];

        $this->conditionalAvailabilityReaderMock->expects(static::atLeastOnce())
            ->method('getGroupedByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($groupedConditionalAvailabilities);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject($this->itemTransferMocks));

        $this->itemExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->withConsecutive([$this->itemTransferMocks[0]], [$this->itemTransferMocks[1]])
            ->willReturnOnConsecutiveCalls(
                $this->itemTransferMocks[0],
                $this->itemTransferMocks[1],
            );

        $this->itemTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDates[0]);

        $this->itemTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDates[0]);

        $this->itemTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDates[1]);

        $this->itemTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDates[1]);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->with($deliveryDates)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->with([$concreteDeliveryDates[1]])
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->expander->expand($this->quoteTransferMock),
        );
    }
}
