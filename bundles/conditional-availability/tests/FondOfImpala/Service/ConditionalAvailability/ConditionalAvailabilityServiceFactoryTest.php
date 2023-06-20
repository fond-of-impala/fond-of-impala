<?php

namespace FondOfImpala\Service\ConditionalAvailability;

use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGenerator;
use FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGenerator;

class ConditionalAvailabilityServiceFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceFactory
     */
    protected $conditionalAvailabilityServiceFactory;

    /**
     * @return void
     */
    protected function _before()
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(ConditionalAvailabilityConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceFactory = new ConditionalAvailabilityServiceFactory();
        $this->conditionalAvailabilityServiceFactory->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testCreateEarliestDeliveryDateGenerator(): void
    {
        static::assertInstanceOf(
            EarliestDeliveryDateGenerator::class,
            $this->conditionalAvailabilityServiceFactory->createEarliestDeliveryDateGenerator(),
        );
    }

    /**
     * @return void
     */
    public function testCreateLatestOrderDateGenerator(): void
    {
        static::assertInstanceOf(
            LatestOrderDateGenerator::class,
            $this->conditionalAvailabilityServiceFactory->createLatestOrderDateGenerator(),
        );
    }
}
