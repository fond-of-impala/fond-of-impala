<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MailTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

class MailHandlerTest extends Unit
{
    protected ErpOrderCancellationMailConfigTransfer|MockObject $erpOrderCancellationMailConfigTransfer;

    protected CustomerTransfer|MockObject $customerTransferMock;

    protected LocaleTransfer|MockObject $localeTransferMock;

    protected ErpOrderCancellationTransfer|MockObject $erpOrderCancellationTransferMock;

    protected ErpOrderCancellationMailConnectorToLocaleFacadeInterface|MockObject $localeFacadeMock;

    protected ErpOrderCancellationMailConnectorToMailFacadeInterface|MockObject $mailFacadeMock;

    protected ErpOrderCancellationMailConnectorRepositoryInterface|MockObject $repositoryMock;

    protected LoggerInterface|MockObject $loggerMock;

    protected MailHandler $handler;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationMailConfigTransfer = $this->getMockBuilder(ErpOrderCancellationMailConfigTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeTransferMock = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeFacadeMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorToLocaleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailFacadeMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorToMailFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->handler = new MailHandler(
            $this->repositoryMock,
            $this->mailFacadeMock,
            $this->localeFacadeMock,
            $this->loggerMock,
        );
    }

    /**
     * @return void
     */
    public function testSendMail(): void
    {
        $self = $this;
        $this->erpOrderCancellationMailConfigTransfer->expects(static::once())
            ->method('getTypeOrFail')
            ->willReturn('type');

        $this->erpOrderCancellationMailConfigTransfer->expects(static::once())
            ->method('getRecipient')
            ->willReturn(null);

        $this->erpOrderCancellationMailConfigTransfer->expects(static::once())
            ->method('getCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::once())
            ->method('getFkCustomerRequested')
            ->willReturn(22);

        $this->repositoryMock->expects(static::once())
            ->method('getCustomerByIdCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::once())
            ->method('getFkLocale')
            ->willReturn(1);

        $this->localeFacadeMock->expects(static::once())
            ->method('getLocaleById')
            ->willReturn($this->localeTransferMock);

        $this->mailFacadeMock->expects(static::once())
            ->method('handleMail')
            ->willReturnCallback(static function (MailTransfer $mailTransfer) use ($self) {
                $self->assertEquals($self->customerTransferMock, $mailTransfer->getCustomer());
                $self->assertEquals($self->localeTransferMock, $mailTransfer->getLocale());
                $self->assertEquals('type', $mailTransfer->getType());
            });

        $response = $this->handler->sendMail($this->erpOrderCancellationMailConfigTransfer);

        $this->assertTrue($response->getIsSuccessful());
        $this->assertSame($this->customerTransferMock, $response->getMail()->getCustomer());
    }

    /**
     * @return void
     */
    public function testSendMailWithException(): void
    {
        $this->erpOrderCancellationMailConfigTransfer->expects(static::once())
            ->method('getTypeOrFail')
            ->willReturn('type');

        $this->erpOrderCancellationMailConfigTransfer->expects(static::once())
            ->method('getRecipient')
            ->willReturn(null);

        $this->erpOrderCancellationMailConfigTransfer->expects(static::exactly(2))
            ->method('getCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::once())
            ->method('getCancellationNumber')
            ->willReturn('123123');

        $this->erpOrderCancellationTransferMock->expects(static::once())
            ->method('getFkCustomerRequested')
            ->willReturn(22);

        $this->repositoryMock->expects(static::once())
            ->method('getCustomerByIdCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::once())
            ->method('getFkLocale')
            ->willReturn(1);

        $this->localeFacadeMock->expects(static::once())
            ->method('getLocaleById')
            ->willReturn($this->localeTransferMock);

        $this->loggerMock->expects(static::once())
            ->method('error');

        $this->mailFacadeMock->expects(static::once())
            ->method('handleMail')
            ->willThrowException(new Exception('error'));

        $response = $this->handler->sendMail($this->erpOrderCancellationMailConfigTransfer);

        $this->assertFalse($response->getIsSuccessful());
    }
}
