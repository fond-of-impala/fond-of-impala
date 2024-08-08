<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\Expander\MailExpanderInterface;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderConfirmationRecipientsOverrideFacadeTest extends Unit
{
    protected OrderConfirmationRecipientsOverrideBusinessFactory|MockObject $factoryMock;

    protected MailTransfer|MockObject $mailTransferMock;

    protected OrderTransfer|MockObject $orderTransferMock;

    protected MailExpanderInterface|MockObject $mailExpanderMock;

    protected OrderConfirmationRecipientsOverrideFacade $facade;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(OrderConfirmationRecipientsOverrideBusinessFactory::class)
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

        $this->facade = new OrderConfirmationRecipientsOverrideFacade();
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
