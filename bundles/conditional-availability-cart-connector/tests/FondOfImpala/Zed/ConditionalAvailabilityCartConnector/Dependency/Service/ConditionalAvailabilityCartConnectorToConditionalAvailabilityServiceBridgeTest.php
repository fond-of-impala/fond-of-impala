<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;

class ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface
     */
    protected $conditionalAvailabilityServiceMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridge
     */
    protected $conditionalAvailabilityCartConnectorToConditionalAvailabilityService;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityService = new ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridge(
            $this->conditionalAvailabilityServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDate(): void
    {
        $earliestDeliveryDate = new DateTime();

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($earliestDeliveryDate);

        static::assertEquals(
            $earliestDeliveryDate,
            $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityService->generateEarliestDeliveryDate(),
        );
    }

    /**
     * @return void
     */
    public function testGenerateOrderDateByDeliveryDate(): void
    {
        $deliveryDate = new DateTime();
        $lastOrderDate = new DateTime();

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->with($deliveryDate)
            ->willReturn($lastOrderDate);

        static::assertEquals(
            $lastOrderDate,
            $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityService
                ->generateLatestOrderDateByDeliveryDate($deliveryDate),
        );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDateByDateTime(): void
    {
        $dateTime = new DateTime();
        $earliestDeliveryDate = new DateTime();

        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDateByDateTime')
            ->with($dateTime)
            ->willReturn($earliestDeliveryDate);

        static::assertEquals(
            $earliestDeliveryDate,
            $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityService
                ->generateEarliestDeliveryDateByDateTime($dateTime),
        );
    }
}
