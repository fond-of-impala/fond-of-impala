<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use Codeception\Test\Unit;
use DateTime;
use DateTimeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DeliveryDateGeneratorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface|MockObject $conditionalAvailabilityServiceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer
     */
    protected ConditionalAvailabilityPeriodTransfer|MockObject $conditionalAvailabilityPeriodTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected ItemTransfer|MockObject $itemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface
     */
    protected DeliveryDateGeneratorInterface $deliveryDateGenerator;

    /**
     * @var \DateTimeInterface
     */
    protected DateTimeInterface $today;

    /**
     * @var \DateTimeInterface
     */
    protected DateTimeInterface $earliestDeliveryDate;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->today = new DateTime('now');
        $this->earliestDeliveryDate = new DateTime('now');

        $this->deliveryDateGenerator = new DeliveryDateGenerator(
            $this->today,
            $this->earliestDeliveryDate,
            $this->conditionalAvailabilityServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerateConcreteByItem(): void
    {
        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn('1970-01-01');

        $concreteDate = $this->deliveryDateGenerator
            ->generateConcreteByItem($this->itemTransferMock);

        static::assertEquals('1970-01-01', $concreteDate);
    }

    /**
     * @return void
     */
    public function testGenerateEarliestByConditionalAvailabilityPeriod(): void
    {
        $startAt = new DateTime('yesterday');
        $startAt = $startAt->format('Y-m-d');

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($startAt);

        $earliestDate = $this->deliveryDateGenerator
            ->generateEarliestByConditionalAvailabilityPeriod($this->conditionalAvailabilityPeriodTransferMock);

        static::assertEquals($this->earliestDeliveryDate->format('Y-m-d'), $earliestDate);
    }

    /**
     * @return void
     */
    public function testGenerateEarliestByConditionalAvailabilityPeriodWithGreaterDateAsToday(): void
    {
        $date = new DateTime('tomorrow');

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($date->format('Y-m-d'));

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDateByDateTime')
            ->with($date)
            ->willReturn($date);

        $earliestDate = $this->deliveryDateGenerator
            ->generateEarliestByConditionalAvailabilityPeriod($this->conditionalAvailabilityPeriodTransferMock);

        static::assertEquals($date->format('Y-m-d'), $earliestDate);
    }
}
