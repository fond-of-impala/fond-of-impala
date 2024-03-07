<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchPublisherInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchUnpublisherInterface;
use Generated\Shared\Transfer\EventEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPageSearchFacadeTest extends Unit
{
    protected MockObject|ConditionalAvailabilityPageSearchBusinessFactory $factoryMock;

    protected array $eventEntityTransferMocks;

    protected MockObject|ConditionalAvailabilityPeriodPageSearchPublisherInterface $publisherMock;

    protected MockObject|ConditionalAvailabilityPeriodPageSearchUnpublisherInterface $unpublisherMock;

    protected ConditionalAvailabilityPageSearchFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMocks = [
            $this->getMockBuilder(EventEntityTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

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
    public function testPublish(): void
    {
        $eventName = ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_PUBLISH;

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchPublisher')
            ->willReturn($this->publisherMock);

        $this->publisherMock->expects(static::atLeastOnce())
            ->method('publish')
            ->with($eventName, $this->eventEntityTransferMocks);

        $this->facade->publish($eventName, $this->eventEntityTransferMocks);
    }

    /**
     * @return void
     */
    public function testPublishByKeys(): void
    {
        $keys = ['foo', 'bar'];

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchPublisher')
            ->willReturn($this->publisherMock);

        $this->publisherMock->expects(static::atLeastOnce())
            ->method('publishByKeys')
            ->with($keys);

        $this->facade->publishByKeys($keys);
    }

    /**
     * @return void
     */
    public function testPublishByConditionalAvailabilityIds(): void
    {
        $conditionalAvailabilityIds = [1, 3];

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchPublisher')
            ->willReturn($this->publisherMock);

        $this->publisherMock->expects(static::atLeastOnce())
            ->method('publishByConditionalAvailabilityIds')
            ->with($conditionalAvailabilityIds);

        $this->facade->publishByConditionalAvailabilityIds($conditionalAvailabilityIds);
    }

    /**
     * @return void
     */
    public function testUnpublish(): void
    {
        $eventName = ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_UNPUBLISH;

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchUnpublisher')
            ->willReturn($this->unpublisherMock);

        $this->unpublisherMock->expects(static::atLeastOnce())
            ->method('unpublish')
            ->with($eventName, $this->eventEntityTransferMocks);

        $this->facade->unpublish($eventName, $this->eventEntityTransferMocks);
    }
}
