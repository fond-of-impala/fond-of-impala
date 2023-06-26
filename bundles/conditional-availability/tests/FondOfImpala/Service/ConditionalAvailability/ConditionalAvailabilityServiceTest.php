<?php

namespace FondOfImpala\Service\ConditionalAvailability;

use Codeception\Test\Unit;
use DateTime;
use FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGeneratorInterface;
use FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGeneratorInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityServiceTest extends Unit
{
    /**
     * @var (\FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceFactory&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityServiceFactory $factoryMock;

    /**
     * @var (\FondOfImpala\Service\ConditionalAvailability\Generator\EarliestDeliveryDateGeneratorInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|EarliestDeliveryDateGeneratorInterface $earliestDeliveryDateGeneratorMock;

    /**
     * @var (\FondOfImpala\Service\ConditionalAvailability\Generator\LatestOrderDateGeneratorInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|LatestOrderDateGeneratorInterface $latestOrderDateGeneratorMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityService
     */
    protected ConditionalAvailabilityService $service;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityServiceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->earliestDeliveryDateGeneratorMock = $this->getMockBuilder(EarliestDeliveryDateGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->latestOrderDateGeneratorMock = $this->getMockBuilder(LatestOrderDateGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new ConditionalAvailabilityService();
        $this->service->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDate(): void
    {
        $dateTime = new DateTime();

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createEarliestDeliveryDateGenerator')
            ->willReturn($this->earliestDeliveryDateGeneratorMock);

        $this->earliestDeliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generate')
            ->willReturn($dateTime);

        static::assertEquals(
            $dateTime,
            $this->service->generateEarliestDeliveryDate(),
        );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDateByDateTime(): void
    {
        $dateTime = new DateTime();

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createEarliestDeliveryDateGenerator')
            ->willReturn($this->earliestDeliveryDateGeneratorMock);

        $this->earliestDeliveryDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByDateTime')
            ->with($dateTime)
            ->willReturn($dateTime);

        static::assertEquals(
            $dateTime,
            $this->service->generateEarliestDeliveryDateByDateTime($dateTime),
        );
    }

    /**
     * @return void
     */
    public function testGenerateLatestOrderDateByDeliveryDate(): void
    {
        $dateTime = new DateTime();

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createLatestOrderDateGenerator')
            ->willReturn($this->latestOrderDateGeneratorMock);

        $this->latestOrderDateGeneratorMock->expects(static::atLeastOnce())
            ->method('generateByDeliveryDate')
            ->with($dateTime)
            ->willReturn($dateTime);

        static::assertEquals(
            $dateTime,
            $this->service->generateLatestOrderDateByDeliveryDate($dateTime),
        );
    }
}
