<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderConfirmationOverride\Persistence\OrderConfirmationOverrideRepository;
use Generated\Shared\Transfer\CustomerCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class MailExpanderTest extends Unit
{
    protected OrderConfirmationOverrideRepository|MockObject $repositoryMock;

    protected MailTransfer|MockObject $mailTransferMock;

    protected OrderTransfer|MockObject $orderTransferMock;

    protected CustomerCollectionTransfer|MockObject $customerCollectionTransferMock;

    protected CustomerTransfer|MockObject $customerTransferMock;

    protected MailRecipientTransfer|MockObject $mailRecipientTransferMock;

    protected MailExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(OrderConfirmationOverrideRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailTransferMock = $this->getMockBuilder(MailTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailRecipientTransferMock = $this->getMockBuilder(MailRecipientTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerCollectionTransferMock = $this->getMockBuilder(CustomerCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new MailExpander($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testExpandAndDoNothing(): void
    {
        $this->orderTransferMock
            ->expects(static::atLeastOnce())
            ->method('getPreventCustomerOrderConfirmationMail')
            ->willReturn(false);

        $this->expander->expand($this->mailTransferMock, $this->orderTransferMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $recipients = new ArrayObject();
        $recipientsBcc = new ArrayObject();
        $customerCollection = new ArrayObject();

        $this->orderTransferMock
            ->expects(static::atLeastOnce())
            ->method('getPreventCustomerOrderConfirmationMail')
            ->willReturn(true);

        $this->mailTransferMock
            ->expects(static::atLeastOnce())
            ->method('getRecipients')
            ->willReturn($recipients);

        $this->mailTransferMock
            ->expects(static::atLeastOnce())
            ->method('getRecipientBccs')
            ->willReturn($recipientsBcc);

        $this->mailRecipientTransferMock
            ->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturnOnConsecutiveCalls(
                'test@test.com',
                'testbcc@test.com',
                'test@test.com',
                'testbcc@test.com',
            );

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('getAllowedCustomerCollectionByMails')
            ->willReturn($this->customerCollectionTransferMock);

        $this->customerCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCustomers')
            ->willReturn($customerCollection);

        $this->customerTransferMock
            ->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturnOnConsecutiveCalls(
                'Test@test.com',
                'testBcc@test.com',
            );

        $this->mailTransferMock
            ->expects(static::atLeastOnce())
            ->method('setRecipients')
            ->willReturnSelf();

        $this->mailTransferMock
            ->expects(static::atLeastOnce())
            ->method('setRecipientBccs')
            ->willReturnSelf();

        $recipients->append($this->mailRecipientTransferMock);
        $recipientsBcc->append($this->mailRecipientTransferMock);
        $customerCollection->append($this->customerTransferMock);
        $customerCollection->append($this->customerTransferMock);

        $this->expander->expand($this->mailTransferMock, $this->orderTransferMock);
    }
}
