<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridgeTest extends Unit
{
    /**
     * @var (\FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityServiceInterface $serviceMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridge
     */
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->serviceMock = $this->getMockBuilder(ConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridge(
            $this->serviceMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDate(): void
    {
        $earliestDeliveryDate = new DateTime();

        $this->serviceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($earliestDeliveryDate);

        static::assertEquals(
            $earliestDeliveryDate,
            $this->bridge->generateEarliestDeliveryDate(),
        );
    }

    /**
     * @return void
     */
    public function testGenerateOrderDateByDeliveryDate(): void
    {
        $deliveryDate = new DateTime();
        $lastOrderDate = new DateTime();

        $this->serviceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->with($deliveryDate)
            ->willReturn($lastOrderDate);

        static::assertEquals(
            $lastOrderDate,
            $this->bridge->generateLatestOrderDateByDeliveryDate($deliveryDate),
        );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDateByDateTime(): void
    {
        $dateTime = new DateTime();
        $earliestDeliveryDate = new DateTime();

        $this->serviceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDateByDateTime')
            ->with($dateTime)
            ->willReturn($earliestDeliveryDate);

        static::assertEquals(
            $earliestDeliveryDate,
            $this->bridge->generateEarliestDeliveryDateByDateTime($dateTime),
        );
    }
}
