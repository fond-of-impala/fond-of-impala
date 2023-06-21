<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;

class EarliestDeliveryDateGeneratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGenerator
     */
    protected $earliestDeliveryDateGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(ConditionalAvailabilityConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->earliestDeliveryDateGenerator = new EarliestDeliveryDateGenerator(
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerateByDateTime(): void
    {
        $this->configMock->expects(static::atLeastOnce())
            ->method('getDefaultDeliveryDays')
            ->willReturn(ConditionalAvailabilityConstants::DEFAULT_VALUE_DEFAULT_DELIVERY_DAYS);

        $earliestDeliveryDate = $this->earliestDeliveryDateGenerator->generateByDateTime(new DateTime('2021-01-21'));

        static::assertEquals(
            '2021-01-25',
            $earliestDeliveryDate->format('Y-m-d'),
        );
    }
}
