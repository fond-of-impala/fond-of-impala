<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;

class ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityServiceMock;

    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge
     */
    protected $conditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityServiceMock = $this->getMockBuilder(ConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dateTime = new DateTime();

        $this->conditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge
            = new ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge(
                $this->conditionalAvailabilityServiceMock,
            );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDateByDateTime(): void
    {
        $this->conditionalAvailabilityServiceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDateByDateTime')
            ->with($this->dateTime)
            ->willReturn($this->dateTime);

        $earliestDeliveryDate = $this->conditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge
            ->generateEarliestDeliveryDateByDateTime($this->dateTime);

        static::assertEquals($this->dateTime, $earliestDeliveryDate);
    }
}
