<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class AllowedProductQuantitySearchEventSubscriberTest extends Unit
{
    protected AllowedProductQuantitySearchEventSubscriber $allowedProductQuantitySearchEventSubscriber;

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

        $this->allowedProductQuantitySearchEventSubscriber = new AllowedProductQuantitySearchEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->assertInstanceOf(EventCollectionInterface::class, $this->allowedProductQuantitySearchEventSubscriber->getSubscribedEvents($this->eventCollectionInterfaceMock));
    }
}
