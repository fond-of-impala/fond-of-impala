<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchPublisherInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchUnpublisherInterface;

class ConditionalAvailabilityPageSearchFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacade
     */
    protected $conditionalAvailabilityPageSearchFacade;

    /**
     * @var array
     */
    protected $concreteIds;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchBusinessFactory
     */
    protected $conditionalAvailabilityPageSearchBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchPublisherInterface
     */
    protected $conditionalAvailabilityPeriodPageSearchPublisherInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchUnpublisherInterface
     */
    protected $conditionalAvailabilityPeriodPageSearchUnpublisherInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->concreteIds = [
            12,
        ];

        $this->conditionalAvailabilityPageSearchBusinessFactoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchPublisherInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchPublisherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchUnpublisherInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPeriodPageSearchUnpublisherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchFacade = new ConditionalAvailabilityPageSearchFacade();
        $this->conditionalAvailabilityPageSearchFacade->setFactory($this->conditionalAvailabilityPageSearchBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityIdsByConcreteIds(): void
    {
        $this->assertIsArray(
            $this->conditionalAvailabilityPageSearchFacade->getConditionalAvailabilityIdsByConcreteIds(
                $this->concreteIds,
            ),
        );
    }

    /**
     * @return void
     */
    public function testPublish(): void
    {
        $this->conditionalAvailabilityPageSearchBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchPublisher')
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchPublisherInterfaceMock);

        $this->conditionalAvailabilityPageSearchFacade->publish(
            $this->concreteIds,
        );
    }

    /**
     * @return void
     */
    public function testUnpublish(): void
    {
        $this->conditionalAvailabilityPageSearchBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createConditionalAvailabilityPeriodPageSearchUnpublisher')
            ->willReturn($this->conditionalAvailabilityPeriodPageSearchUnpublisherInterfaceMock);

        $this->conditionalAvailabilityPageSearchFacade->unpublish(
            $this->concreteIds,
        );
    }
}
