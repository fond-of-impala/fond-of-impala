<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderConfirmationOverride\Business\Expander\MailExpanderInterface;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderConfirmationOverrideFacadeTest extends Unit
{
    protected OrderConfirmationOverrideBusinessFactory|MockObject $factoryMock;

    protected MailTransfer|MockObject $mailTransferMock;

    protected OrderTransfer|MockObject $orderTransferMock;

    protected MailExpanderInterface|MockObject $mailExpanderMock;

    protected OrderConfirmationOverrideFacade $facade;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(OrderConfirmationOverrideBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailExpanderMock = $this->getMockBuilder(MailExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailTransferMock = $this->getMockBuilder(MailTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new OrderConfirmationOverrideFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderMailTransfer(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createMailExpander')
            ->willReturn($this->mailExpanderMock);

        $this->mailExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->mailTransferMock);

        $this->facade->expandOrderMailTransfer($this->mailTransferMock, $this->orderTransferMock);
    }
}
