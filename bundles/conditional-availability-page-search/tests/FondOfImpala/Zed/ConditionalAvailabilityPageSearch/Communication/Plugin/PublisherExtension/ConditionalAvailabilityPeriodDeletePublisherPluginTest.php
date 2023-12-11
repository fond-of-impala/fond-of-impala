<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\PublisherExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacade;
use Generated\Shared\Transfer\EventEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodDeletePublisherPluginTest extends Unit
{
    protected ConditionalAvailabilityPageSearchFacade|MockObject $facadeMock;

    protected EventEntityTransfer|MockObject $eventEntityTransferMock;

    protected ConditionalAvailabilityPeriodDeletePublisherPlugin $plugin;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMock = $this->getMockBuilder(EventEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ConditionalAvailabilityPeriodDeletePublisherPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        static::assertEquals(
            [
                ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_UNPUBLISH,
                ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_DELETE,
            ],
            $this->plugin->getSubscribedEvents(),
        );
    }

    /**
     * @return void
     */
    public function testHandleBulk(): void
    {
        $eventName = ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_DELETE;
        $eventEntityTransferMocks = [
            $this->eventEntityTransferMock,
        ];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('unpublish')
            ->with($eventName, $eventEntityTransferMocks);

        $this->plugin->handleBulk($eventEntityTransferMocks, $eventName);
    }
}
