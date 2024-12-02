<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\Mail;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepository;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;

class NotifyApprovedErpOrderCancellationMailTypePluginTest extends Unit
{
    protected MailBuilderInterface|MockObject $mailBuilderMock;

    protected ErpOrderCancellationTransfer|MockObject $erpOrderCancellationTransferMock;

    protected ErpOrderCancellationMailConfigTransfer|MockObject $erpOrderCancellationMailConfigTransferMock;

    protected CustomerTransfer|MockObject $customerTransferMock;

    protected MailTransfer|MockObject $mailTransferMock;

    protected ErpOrderCancellationNotifyTransfer|MockObject $notifyTransferMock;

    protected ErpOrderCancellationNotifyTransfer|MockObject $notifyTransferMock2;

    protected ErpOrderCancellationMailConfigResponseTransfer|MockObject $erpOrderCancellationMailConfigResponseTransferMock;

    protected ErpOrderCancellationMailConnectorRepository|MockObject $repositoryMock;

    protected ErpOrderCancellationMailConnectorConfig|MockObject $configMock;

    protected NotifyApprovedErpOrderCancellationMailTypePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->mailBuilderMock = $this->getMockBuilder(MailBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailTransferMock = $this->getMockBuilder(MailTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationMailConfigTransferMock = $this->getMockBuilder(ErpOrderCancellationMailConfigTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->notifyTransferMock = $this->getMockBuilder(ErpOrderCancellationNotifyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->notifyTransferMock2 = $this->getMockBuilder(ErpOrderCancellationNotifyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationMailConfigResponseTransferMock = $this->getMockBuilder(ErpOrderCancellationMailConfigResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new NotifyApprovedErpOrderCancellationMailTypePlugin();
        $this->plugin->setRepository($this->repositoryMock);
        $this->plugin->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        $this->assertEquals(NotifyApprovedErpOrderCancellationMailTypePlugin::MAIL_TYPE, $this->plugin->getName());
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $self = $this;
        $notify = new ArrayObject([$this->notifyTransferMock, $this->notifyTransferMock2]);
        $this->mailBuilderMock->expects(static::once())
            ->method('setSubject')
            ->willReturnCallback(static function (string $subject) use ($self) {
                static::assertEquals(sprintf('%s.subject', NotifyApprovedErpOrderCancellationMailTypePlugin::MAIL_TYPE), $subject);

                return $self;
            });

        $this->mailBuilderMock->expects(static::once())
            ->method('setHtmlTemplate')
            ->willReturnCallback(static function (string $template) use ($self) {
                static::assertEquals('ErpOrderCancellationMailConnector/Mail/notify_erp_order_cancellation.html.twig', $template);

                return $self;
            });

        $this->mailBuilderMock->expects(static::once())
            ->method('setTextTemplate')
            ->willReturnCallback(static function (string $template) use ($self) {
                static::assertEquals('ErpOrderCancellationMailConnector/Mail/notify_erp_order_cancellation.text.twig', $template);

                return $self;
            });

        $this->mailBuilderMock->expects(static::once())
            ->method('setTextTemplate')
            ->willReturnCallback(static function (string $template) use ($self) {
                static::assertEquals('ErpOrderCancellationMailConnector/Mail/notify_erp_order_cancellation.text.twig', $template);

                return $self;
            });

        $this->mailBuilderMock->expects(static::once())
            ->method('getMailTransfer')
            ->willReturn($this->mailTransferMock);

        $this->mailTransferMock->expects(static::once())
            ->method('requireErpOrderCancellationMailConfig')
            ->willReturnSelf();

        $this->mailTransferMock->expects(static::once())
            ->method('getErpOrderCancellationMailConfig')
            ->willReturn($this->erpOrderCancellationMailConfigTransferMock);

        $this->mailTransferMock->expects(static::once())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->erpOrderCancellationMailConfigTransferMock->expects(static::once())
            ->method('getCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::once())
            ->method('getNotify')
            ->willReturn($notify);

        $this->notifyTransferMock->expects(static::once())
            ->method('getEmail')
            ->willReturn('test2@test.de');

        $this->notifyTransferMock2->expects(static::once())
            ->method('getEmail')
            ->willReturn('test3@test.de');

        $this->customerTransferMock->expects(static::once())
            ->method('getEmail')
            ->willReturn('test@test.de');

        $this->mailTransferMock->expects(static::once())
            ->method('addRecipient')
            ->willReturnCallback(static function (MailRecipientTransfer $mailRecipientTransfer) {
                static::assertEquals('test@test.de', $mailRecipientTransfer->getEmail());

                return $mailRecipientTransfer;
            });

        $callCount = $this->exactly(2);
        $this->mailTransferMock->expects($callCount)
            ->method('addRecipientBcc')->willReturnCallback(static function (MailRecipientTransfer $mailRecipientTransfer) use ($callCount) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        static::assertEquals('test2@test.de', $mailRecipientTransfer->getEmail());

                        return $mailRecipientTransfer;
                    case 2:
                        static::assertEquals('test3@test.de', $mailRecipientTransfer->getEmail());

                        return $mailRecipientTransfer;
                }

                return $mailRecipientTransfer;
            });

        $this->mailBuilderMock->expects(static::once())
            ->method('setSender')
            ->willReturnCallback(static function (string $emil, $name) use ($self) {
                static::assertEquals('mail.sender.email', $emil);
                static::assertEquals('mail.sender.name', $name);

                return $self;
            });

        $this->plugin->build($this->mailBuilderMock);
    }
}
