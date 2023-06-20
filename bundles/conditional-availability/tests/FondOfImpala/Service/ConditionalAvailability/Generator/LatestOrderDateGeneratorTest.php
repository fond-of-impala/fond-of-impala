<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;

class LatestOrderDateGeneratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\Generator\EarliestOrderDateGeneratorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $earliestOrderDateGeneratorMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGenerator
     */
    protected $latestOrderDateGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->earliestOrderDateGeneratorMock = $this->getMockBuilder(EarliestOrderDateGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(ConditionalAvailabilityConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->latestOrderDateGenerator = new LatestOrderDateGenerator(
            $this->earliestOrderDateGeneratorMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerateByDeliveryDate(): void
    {
        $this->earliestOrderDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn(new DateTime('2021-02-11'));

        $this->configMock->expects(static::atLeastOnce())
            ->method('getDefaultDeliveryDays')
            ->willReturn(ConditionalAvailabilityConstants::DEFAULT_VALUE_DEFAULT_DELIVERY_DAYS);

        static::assertEquals(
            new DateTime('2021-02-12'),
            $this->latestOrderDateGenerator->generateByDeliveryDate(new DateTime('2021-02-16')),
        );
    }

    /**
     * @return void
     */
    public function testGenerateByDeliveryDateWithExceededLimit(): void
    {
        $this->earliestOrderDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn(new DateTime('2021-02-13'));

        $this->configMock->expects(static::atLeastOnce())
            ->method('getDefaultDeliveryDays')
            ->willReturn(ConditionalAvailabilityConstants::DEFAULT_VALUE_DEFAULT_DELIVERY_DAYS);

        static::assertEquals(
            new DateTime('2021-02-13'),
            $this->latestOrderDateGenerator->generateByDeliveryDate(new DateTime('2021-02-15')),
        );
    }
}
