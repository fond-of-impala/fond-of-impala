<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\PublisherExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\PriceProductPriceListEvents;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacade;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToEventBehaviorFacadeInterface;
use Generated\Shared\Transfer\EventEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductAbstractPriceListWritePublisherPluginTest extends Unit
{
    protected PriceProductPriceListPageSearchFacade|MockObject $facadeMock;

    protected PriceProductPriceListPageSearchCommunicationFactory|MockObject $factoryMock;

    protected EventEntityTransfer|MockObject $eventEntityTransferMock;

    protected MockObject|PriceProductPriceListPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacadeMock;

    protected PriceProductAbstractPriceListWritePublisherPlugin $plugin;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(PriceProductPriceListPageSearchFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(PriceProductPriceListPageSearchCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(PriceProductPriceListPageSearchToEventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMock = $this->getMockBuilder(EventEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new PriceProductAbstractPriceListWritePublisherPlugin();
        $this->plugin->setFacade($this->facadeMock);
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        static::assertEquals(
            [
                PriceProductPriceListEvents::PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PUBLISH,
                PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_CREATE,
                PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_UPDATE,
            ],
            $this->plugin->getSubscribedEvents(),
        );
    }

    /**
     * @return void
     */
    public function testHandleBulk(): void
    {
        $eventTransferIds = [5];
        $eventName = PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_CREATE;
        $eventEntityTransferMocks = [
            $this->eventEntityTransferMock,
        ];

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getEventBehaviorFacade')
            ->willReturn($this->eventBehaviorFacadeMock);

        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('getEventTransferIds')
            ->with($eventEntityTransferMocks)
            ->willReturn($eventTransferIds);

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('publishAbstractPriceProductPriceList')
            ->with($eventTransferIds);

        $this->plugin->handleBulk($eventEntityTransferMocks, $eventName);
    }
}
