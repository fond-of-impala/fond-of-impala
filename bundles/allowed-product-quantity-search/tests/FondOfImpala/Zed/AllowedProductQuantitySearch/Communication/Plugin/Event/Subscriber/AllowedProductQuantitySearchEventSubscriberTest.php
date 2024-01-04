<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class AllowedProductQuantitySearchEventSubscriberTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\Plugin\Event\Subscriber\AllowedProductQuantitySearchEventSubscriber
     */
    protected $allowedProductQuantitySearchEventSubscriber;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected $eventCollectionInterfaceMock;

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
