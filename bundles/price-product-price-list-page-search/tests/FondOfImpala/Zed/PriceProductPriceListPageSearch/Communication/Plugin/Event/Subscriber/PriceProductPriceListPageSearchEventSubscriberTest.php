<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class PriceProductPriceListPageSearchEventSubscriberTest extends Unit
{
    protected PriceProductPriceListPageSearchEventSubscriber $priceProductPriceListPageSearchEventSubscriber;

    protected MockObject|EventCollectionInterface $eventCollectionMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchEventSubscriber = new PriceProductPriceListPageSearchEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionMock->expects(static::exactly(8))
            ->method('addListenerQueued')
            ->willReturn($this->eventCollectionMock);

        static::assertEquals(
            $this->eventCollectionMock,
            $this->priceProductPriceListPageSearchEventSubscriber->getSubscribedEvents(
                $this->eventCollectionMock,
            ),
        );
    }
}
