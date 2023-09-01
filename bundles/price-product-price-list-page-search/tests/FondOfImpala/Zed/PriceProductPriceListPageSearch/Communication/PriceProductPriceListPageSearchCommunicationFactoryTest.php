<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToEventBehaviorFacadeBridge;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListPageSearchCommunicationFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory
     */
    protected PriceProductPriceListPageSearchCommunicationFactory $priceProductPriceListPageSearchCommunicationFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToEventBehaviorFacadeInterface
     */
    protected MockObject|PriceProductPriceListPageSearchToEventBehaviorFacadeInterface $priceProductPriceListPageSearchToEventBehaviorFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchToEventBehaviorFacadeInterfaceMock = $this->getMockBuilder(PriceProductPriceListPageSearchToEventBehaviorFacadeBridge::class)
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
            ->willReturn($this->priceProductPriceListPageSearchToEventBehaviorFacadeInterfaceMock);

        static::assertInstanceOf(
            PriceProductPriceListPageSearchToEventBehaviorFacadeBridge::class,
            $this->priceProductPriceListPageSearchCommunicationFactory->getEventBehaviorFacade(),
        );
    }
}
