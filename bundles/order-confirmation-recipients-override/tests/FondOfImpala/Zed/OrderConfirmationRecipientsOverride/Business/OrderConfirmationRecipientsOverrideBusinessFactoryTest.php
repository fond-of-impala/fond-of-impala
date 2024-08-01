<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\Expander\MailExpander;
use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Persistence\OrderConfirmationRecipientsOverrideRepository;
use PHPUnit\Framework\MockObject\MockObject;

class OrderConfirmationRecipientsOverrideBusinessFactoryTest extends Unit
{
    protected OrderConfirmationRecipientsOverrideRepository|MockObject $repositoryMock;

    protected OrderConfirmationRecipientsOverrideBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(OrderConfirmationRecipientsOverrideRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new OrderConfirmationRecipientsOverrideBusinessFactory();
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
