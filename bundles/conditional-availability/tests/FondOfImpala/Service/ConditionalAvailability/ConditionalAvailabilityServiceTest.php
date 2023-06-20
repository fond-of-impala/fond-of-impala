<?php

namespace FondOfImpala\Service\ConditionalAvailability;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGeneratorInterface;
use FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGeneratorInterface;

class ConditionalAvailabilityServiceTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceFactory
     */
    protected $conditionalAvailabilityServiceFactoryMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGeneratorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $earliestDeliveryDateGeneratorMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGeneratorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $latestOrderDateGeneratorMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityService
     */
    protected $conditionalAvailabilityService;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityServiceFactoryMock = $this->getMockBuilder(ConditionalAvailabilityServiceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->earliestDeliveryDateGeneratorMock = $this->getMockBuilder(EarliestDeliveryDateGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->latestOrderDateGeneratorMock = $this->getMockBuilder(LatestOrderDateGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityService = new ConditionalAvailabilityService();
        $this->conditionalAvailabilityService->setFactory($this->conditionalAvailabilityServiceFactoryMock);
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDate(): void
    {
        $dateTime = new DateTime();

        $this->conditionalAvailabilityServiceFactoryMock->expects(static::atLeastOnce())
            ->method('createEarliestDeliveryDateGenerator')
            ->willReturn($this->earliestDeliveryDateGeneratorMock);

        $this->earliestDeliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn($dateTime);

        static::assertEquals(
            $dateTime,
            $this->conditionalAvailabilityService->generateEarliestDeliveryDate(),
        );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDateByDateTime(): void
    {
        $dateTime = new DateTime();

        $this->conditionalAvailabilityServiceFactoryMock->expects(static::atLeastOnce())
            ->method('createEarliestDeliveryDateGenerator')
            ->willReturn($this->earliestDeliveryDateGeneratorMock);

        $this->earliestDeliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByDateTime')
            ->with($dateTime)
            ->willReturn($dateTime);

        static::assertEquals(
            $dateTime,
            $this->conditionalAvailabilityService->generateEarliestDeliveryDateByDateTime($dateTime),
        );
    }

    /**
     * @return void
     */
    public function testGenerateLatestOrderDateByDeliveryDate(): void
    {
        $dateTime = new DateTime();

        $this->conditionalAvailabilityServiceFactoryMock->expects(static::atLeastOnce())
            ->method('createLatestOrderDateGenerator')
            ->willReturn($this->latestOrderDateGeneratorMock);

        $this->latestOrderDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByDeliveryDate')
            ->with($dateTime)
            ->willReturn($dateTime);

        static::assertEquals(
            $dateTime,
            $this->conditionalAvailabilityService->generateLatestOrderDateByDeliveryDate($dateTime),
        );
    }
}
