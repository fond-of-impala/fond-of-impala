<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;

class ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface
     */
    protected $conditionalAvailabilityServiceMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge
     */
    protected $conditionalAvailabilityCheckoutConnectorToConditionalAvailabilityService;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCheckoutConnectorToConditionalAvailabilityService = new ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge(
            $this->conditionalAvailabilityServiceMock,
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
            $this->conditionalAvailabilityCheckoutConnectorToConditionalAvailabilityService
                ->generateLatestOrderDateByDeliveryDate($deliveryDate),
        );
    }
}
