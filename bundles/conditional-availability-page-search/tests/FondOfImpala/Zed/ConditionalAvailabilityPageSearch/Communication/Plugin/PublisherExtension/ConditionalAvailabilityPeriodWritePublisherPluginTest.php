<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\PublisherExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacade;
use Generated\Shared\Transfer\EventEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodWritePublisherPluginTest extends Unit
{
    protected ConditionalAvailabilityPageSearchFacade|MockObject $facadeMock;

    protected EventEntityTransfer|MockObject $eventEntityTransferMock;

    protected ConditionalAvailabilityPeriodWritePublisherPlugin $plugin;

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

        $this->plugin = new ConditionalAvailabilityPeriodWritePublisherPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        static::assertEquals(
            [
                ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_PUBLISH,
                ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_CREATE,
                ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_UPDATE,
            ],
            $this->plugin->getSubscribedEvents(),
        );
    }

    /**
     * @return void
     */
    public function testHandleBulk(): void
    {
        $eventName = ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_CREATE;
        $eventEntityTransferMocks = [
            $this->eventEntityTransferMock,
        ];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('publish')
            ->with($eventName, $eventEntityTransferMocks);

        $this->plugin->handleBulk($eventEntityTransferMocks, $eventName);
    }
}
