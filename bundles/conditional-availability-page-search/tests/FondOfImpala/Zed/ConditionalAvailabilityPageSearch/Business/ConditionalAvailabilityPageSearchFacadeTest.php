<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchPublisherInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchUnpublisherInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPageSearchFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacade
     */
    protected ConditionalAvailabilityPageSearchFacade $facade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchBusinessFactory
     */
    protected MockObject|ConditionalAvailabilityPageSearchBusinessFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchPublisherInterface
     */
    protected MockObject|ConditionalAvailabilityPeriodPageSearchPublisherInterface $publisherMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchUnpublisherInterface
     */
    protected MockObject|ConditionalAvailabilityPeriodPageSearchUnpublisherInterface $unpublisherMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->publisherMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchPublisherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->unpublisherMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchUnpublisherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ConditionalAvailabilityPageSearchFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityIdsByConcreteIds(): void
    {
        static::assertIsArray(
            $this->facade->getConditionalAvailabilityIdsByConcreteIds([1])
        );
    }

    /**
     * @return void
     */
    public function testPublish(): void
    {
        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchPublisher')
            ->willReturn($this->publisherMock);

        $this->facade->publish([1]);
    }

    /**
     * @return void
     */
    public function testUnpublish(): void
    {
        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchUnpublisher')
            ->willReturn($this->unpublisherMock);

        $this->facade->unpublish([1]);
    }
}
