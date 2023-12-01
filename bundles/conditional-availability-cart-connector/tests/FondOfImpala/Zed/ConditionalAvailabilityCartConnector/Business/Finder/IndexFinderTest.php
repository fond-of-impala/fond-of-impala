<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder;

use ArrayObject;
use Codeception\Test\Unit;
use DateInterval;
use DateTime;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class IndexFinderTest extends Unit
{
    protected DateTime $today;

    protected DateTime $earliestDeliveryDate;

    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface|MockObject $conditionalAvailabilityServiceMock;

    /**
     * @var array<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $conditionalAvailabilityPeriodTransferMocks;

    protected MockObject|ItemTransfer $itemTransferMock;

    protected IndexFinder $finder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->today = new DateTime();

        $this->earliestDeliveryDate = new DateTime();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface::class)
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
        ];

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->finder = new IndexFinder(
            $this->today,
            $this->earliestDeliveryDate,
            $this->conditionalAvailabilityServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindEarliestFromConditionalAvailabilityPeriods(): void
    {
        $quantity = 10;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($quantity);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (clone $this->today)->sub(new DateInterval('P10D'))
                    ->format('Y-m-d'),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(5);

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (clone $this->today)->add(new DateInterval('P10D'))
                    ->format('Y-m-d'),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(10);

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::never())
            ->method('getEndAt');

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::never())
            ->method('getQuantity');

        static::assertEquals(
            1,
            $this->finder->findEarliestFromConditionalAvailabilityPeriods(
                new ArrayObject($this->conditionalAvailabilityPeriodTransferMocks),
                $this->itemTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindEarliestFromConditionalAvailabilityPeriodsInThePast(): void
    {
        $quantity = 10;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($quantity);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (clone $this->today)->sub(new DateInterval('P10D'))
                    ->format('Y-m-d'),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        static::assertEquals(
            null,
            $this->finder->findEarliestFromConditionalAvailabilityPeriods(
                new ArrayObject([$this->conditionalAvailabilityPeriodTransferMocks[0]]),
                $this->itemTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindEarliestFromInvalidConditionalAvailabilityPeriods(): void
    {
        $quantity = 10;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($quantity);

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (clone $this->today)->sub(new DateInterval('P10D'))
                    ->format('Y-m-d'),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(1);

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn(
                (clone $this->today)->add(new DateInterval('P10D'))
                    ->format('Y-m-d'),
            );

        $this->conditionalAvailabilityPeriodTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(2);

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::never())
            ->method('getEndAt');

        $this->conditionalAvailabilityPeriodTransferMocks[2]->expects(static::never())
            ->method('getQuantity');

        static::assertEquals(
            null,
            $this->finder->findEarliestFromConditionalAvailabilityPeriods(
                new ArrayObject($this->conditionalAvailabilityPeriodTransferMocks),
                $this->itemTransferMock,
            ),
        );
    }
}
