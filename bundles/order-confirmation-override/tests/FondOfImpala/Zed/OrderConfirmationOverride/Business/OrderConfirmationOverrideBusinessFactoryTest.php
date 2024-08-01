<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderConfirmationOverride\Business\Expander\MailExpander;
use FondOfImpala\Zed\OrderConfirmationOverride\Persistence\OrderConfirmationOverrideRepository;
use PHPUnit\Framework\MockObject\MockObject;

class OrderConfirmationOverrideBusinessFactoryTest extends Unit
{
    protected OrderConfirmationOverrideRepository|MockObject $repositoryMock;

    protected OrderConfirmationOverrideBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(OrderConfirmationOverrideRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new OrderConfirmationOverrideBusinessFactory();
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateMailExpander(): void
    {
        static::assertInstanceOf(
            MailExpander::class,
            $this->factory->createMailExpander(),
        );
    }
}
