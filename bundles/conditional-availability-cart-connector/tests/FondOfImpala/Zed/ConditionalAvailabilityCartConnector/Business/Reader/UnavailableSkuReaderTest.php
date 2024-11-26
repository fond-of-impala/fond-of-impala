<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducerInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class UnavailableSkuReaderTest extends Unit
{
    protected MockObject|ConditionalAvailabilityReaderInterface $conditionalAvailabilityReaderMock;

    protected MockObject|ConditionalAvailabilityPeriodsFilterInterface $conditionalAvailabilityPeriodsFilterMock;

    protected IndexFinderInterface|MockObject $indexFinderMock;

    protected ConditionalAvailabilityPeriodsReducerInterface|MockObject $conditionalAvailabilityPeriodsReducerMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ArrayObject|MockObject $groupedConditionalAvailabilityTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $itemTransferMocks;

    /**
     * @var \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer>|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ArrayObject|MockObject $conditionalAvailabilityPeriodTransferMocks;

    protected UnavailableSkuReader $reader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityReaderMock = $this->getMockBuilder(ConditionalAvailabilityReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodsFilterMock = $this->getMockBuilder(ConditionalAvailabilityPeriodsFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->indexFinderMock = $this->getMockBuilder(IndexFinderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodsReducerMock = $this->getMockBuilder(ConditionalAvailabilityPeriodsReducerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->groupedConditionalAvailabilityTransferMocks = $this->getMockBuilder(ArrayObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = [
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->conditionalAvailabilityPeriodTransferMocks = $this->getMockBuilder(ArrayObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new UnavailableSkuReader(
            $this->conditionalAvailabilityReaderMock,
            $this->conditionalAvailabilityPeriodsFilterMock,
            $this->indexFinderMock,
            $this->conditionalAvailabilityPeriodsReducerMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByQuote(): void
    {
        $self = $this;

        $skus = [
            'foo',
            'bar',
            'oof',
        ];
        $unavailableSkus = array_slice($skus, 0, 2);
        $index = 3;

        $this->conditionalAvailabilityReaderMock->expects(static::atLeastOnce())
            ->method('getGroupedByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->groupedConditionalAvailabilityTransferMocks);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject($this->itemTransferMocks));

        $callCount = $this->atLeastOnce();
        $this->conditionalAvailabilityPeriodsFilterMock->expects($callCount)
            ->method('filterFromGroupedConditionalAvailabilitiesByItem')
            ->willReturnCallback(static function (ArrayObject $conditionalAvailabilityTransfers, ItemTransfer $itemTransfer) use ($self, $callCount) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame($self->groupedConditionalAvailabilityTransferMocks, $conditionalAvailabilityTransfers);
                        $self->assertSame($self->itemTransferMocks[0], $itemTransfer);

                        return null;
                    case 2:
                        $self->assertSame($self->groupedConditionalAvailabilityTransferMocks, $conditionalAvailabilityTransfers);
                        $self->assertSame($self->itemTransferMocks[1], $itemTransfer);

                        return $self->conditionalAvailabilityPeriodTransferMocks;
                    case 3:
                        $self->assertSame($self->groupedConditionalAvailabilityTransferMocks, $conditionalAvailabilityTransfers);
                        $self->assertSame($self->itemTransferMocks[2], $itemTransfer);

                        return $self->conditionalAvailabilityPeriodTransferMocks;
                }

                throw new Exception('Unexpected call count');
            });

        $callCount2 = $this->atLeastOnce();
        $this->indexFinderMock->expects($callCount2)
            ->method('findConcreteFromConditionalAvailabilityPeriods')
            ->willReturnCallback(static function (ArrayObject $conditionalAvailabilityTransfers, ItemTransfer $itemTransfer) use ($self, $callCount2, $index) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount2, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount2->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount2->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertEquals($self->groupedConditionalAvailabilityTransferMocks, $conditionalAvailabilityTransfers);
                        $self->assertEquals($self->itemTransferMocks[0], $itemTransfer);

                        return null;
                    case 2:
                        $self->assertEquals($self->groupedConditionalAvailabilityTransferMocks, $conditionalAvailabilityTransfers);
                        $self->assertEquals($self->itemTransferMocks[1], $itemTransfer);

                        return $index;
                }

                throw new Exception('Unexpected call count');
            });

        $this->conditionalAvailabilityPeriodsReducerMock->expects(static::atLeastOnce())
            ->method('reduceByItemAndEffectedIndex')
            ->with(
                $this->conditionalAvailabilityPeriodTransferMocks,
                $this->itemTransferMocks[2],
                $index,
            )
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->itemTransferMocks[0]->expects(static::atLeastOnce())
            ->method('requireSku')
            ->willReturn($this->itemTransferMocks[0]);

        $this->itemTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($skus[0]);

        $this->itemTransferMocks[1]->expects(static::atLeastOnce())
            ->method('requireSku')
            ->willReturn($this->itemTransferMocks[1]);

        $this->itemTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($skus[1]);

        $this->itemTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($skus[2]);

        $this->itemTransferMocks[2]->expects(static::atLeastOnce())
            ->method('requireSku')
            ->willReturn($this->itemTransferMocks[2]);

        static::assertEquals($unavailableSkus, $this->reader->getByQuote($this->quoteTransferMock));
    }
}
