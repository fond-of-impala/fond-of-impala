<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridgeTest extends Unit
{
    /**
     * @var (\FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityServiceInterface $serviceMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge
     */
    protected ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->serviceMock = $this->getMockBuilder(ConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge(
            $this->serviceMock,
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
            $this->bridge
                ->generateLatestOrderDateByDeliveryDate($deliveryDate),
        );
    }
}
