<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToEventBehaviorFacadeBridge;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListPageSearchCommunicationFactoryTest extends Unit
{
    protected PriceProductPriceListPageSearchCommunicationFactory $priceProductPriceListPageSearchCommunicationFactory;

    protected MockObject|Container $containerMock;

    protected MockObject|PriceProductPriceListPageSearchToEventBehaviorFacadeBridge $eventBehaviorFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(PriceProductPriceListPageSearchToEventBehaviorFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchCommunicationFactory = new PriceProductPriceListPageSearchCommunicationFactory();
        $this->priceProductPriceListPageSearchCommunicationFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetEventBehaviorFacade(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn($this->eventBehaviorFacadeMock);

        static::assertInstanceOf(
            PriceProductPriceListPageSearchToEventBehaviorFacadeBridge::class,
            $this->priceProductPriceListPageSearchCommunicationFactory->getEventBehaviorFacade(),
        );
    }
}
