<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface
     */
    protected MockObject|ConditionalAvailabilityServiceInterface $conditionalAvailabilityServiceMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge
     */
    protected ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge $serviceBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceBridge
            = new ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge(
                $this->conditionalAvailabilityServiceMock,
            );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDateByDateTime(): void
    {
        $dateTime = new DateTime();
        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDateByDateTime')
            ->with($dateTime)
            ->willReturn($dateTime);

        $earliestDeliveryDate = $this->serviceBridge->generateEarliestDeliveryDateByDateTime($dateTime);

        static::assertEquals($dateTime, $earliestDeliveryDate);
    }
}
