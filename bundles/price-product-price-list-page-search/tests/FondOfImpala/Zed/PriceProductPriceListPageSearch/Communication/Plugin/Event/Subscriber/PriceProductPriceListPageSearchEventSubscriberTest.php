<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class PriceProductPriceListPageSearchEventSubscriberTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber\PriceProductPriceListPageSearchEventSubscriber
     */
    protected PriceProductPriceListPageSearchEventSubscriber $priceProductPriceListPageSearchEventSubscriber;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected MockObject|EventCollectionInterface $eventCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventCollectionInterfaceMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchEventSubscriber = new PriceProductPriceListPageSearchEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->priceProductPriceListPageSearchEventSubscriber->getSubscribedEvents($this->eventCollectionInterfaceMock);
    }
}
