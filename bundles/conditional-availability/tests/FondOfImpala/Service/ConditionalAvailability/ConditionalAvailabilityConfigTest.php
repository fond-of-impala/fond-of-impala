<?php

namespace FondOfImpala\Service\ConditionalAvailability;

use Codeception\Test\Unit;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;

class ConditionalAvailabilityConfigTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityConfig;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityConfig = $this->getMockBuilder(ConditionalAvailabilityConfig::class)
            ->onlyMethods(['get'])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testGetDefaultDeliveryDays(): void
    {
        $this->conditionalAvailabilityConfig->expects(static::atLeastOnce())
            ->method('get')
            ->with(
                ConditionalAvailabilityConstants::DEFAULT_DELIVERY_DAYS,
                ConditionalAvailabilityConstants::DEFAULT_VALUE_DEFAULT_DELIVERY_DAYS,
            )->willReturn(ConditionalAvailabilityConstants::DEFAULT_VALUE_DEFAULT_DELIVERY_DAYS);

        static::assertEquals(
            ConditionalAvailabilityConstants::DEFAULT_VALUE_DEFAULT_DELIVERY_DAYS,
            $this->conditionalAvailabilityConfig->getDefaultDeliveryDays(),
        );
    }

    /**
     * @return void
     */
    public function testGetCustomDefaultDeliveryDays(): void
    {
        $this->conditionalAvailabilityConfig->expects(static::atLeastOnce())
            ->method('get')
            ->with(
                ConditionalAvailabilityConstants::DEFAULT_DELIVERY_DAYS,
                ConditionalAvailabilityConstants::DEFAULT_VALUE_DEFAULT_DELIVERY_DAYS,
            )->willReturn(2);

        static::assertEquals(
            2,
            $this->conditionalAvailabilityConfig->getDefaultDeliveryDays(),
        );
    }
}
