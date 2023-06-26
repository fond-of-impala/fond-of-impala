<?php

namespace FondOfImpala\Service\ConditionalAvailability;

use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGenerator;
use FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGenerator;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityServiceFactoryTest extends Unit
{
    /**
     * @var (\FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityConfig|MockObject $configMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceFactory
     */
    protected ConditionalAvailabilityServiceFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(ConditionalAvailabilityConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityServiceFactory();
        $this->factory->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testCreateEarliestDeliveryDateGenerator(): void
    {
        static::assertInstanceOf(
            EarliestDeliveryDateGenerator::class,
            $this->factory->createEarliestDeliveryDateGenerator(),
        );
    }

    /**
     * @return void
     */
    public function testCreateLatestOrderDateGenerator(): void
    {
        static::assertInstanceOf(
            LatestOrderDateGenerator::class,
            $this->factory->createLatestOrderDateGenerator(),
        );
    }
}
