<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\ErpOrderCancellation;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\ErpOrderCancellationMailConnectorFacade;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\Mail\NotifyApprovedErpOrderCancellationMailTypePlugin;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class NotifyApprovedErpOrderCancellationPostTransactionPluginTest extends Unit
{
    protected ErpOrderCancellationResponseTransfer|MockObject $erpOrderCancellationResponseTransferMock;

    protected ErpOrderCancellationTransfer|MockObject $erpOrderCancellationTransferMock;

    protected ErpOrderCancellationMailConfigResponseTransfer|MockObject $erpOrderCancellationMailConfigResponseTransferMock;

    protected ErpOrderCancellationMailConnectorConfig|MockObject $configMock;

    protected ErpOrderCancellationMailConnectorFacade|MockObject $facadeMock;

    protected NotifyApprovedErpOrderCancellationPostTransactionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationResponseTransferMock = $this->getMockBuilder(ErpOrderCancellationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationMailConfigResponseTransferMock = $this->getMockBuilder(ErpOrderCancellationMailConfigResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new NotifyApprovedErpOrderCancellationPostTransactionPlugin();
        $this->plugin->setFacade($this->facadeMock);
        $this->plugin->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testPostTransaction(): void
    {
        $self = $this;
        $this->erpOrderCancellationResponseTransferMock->expects(static::once())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects(static::once())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->erpOrderCancellationTransferMock->expects(static::once())
            ->method('getState')
            ->willReturn('approved');

        $this->configMock->expects(static::once())
            ->method('getRolesToNotify')
            ->willReturn([]);

        $this->facadeMock->expects(static::once())
            ->method('handleMails')
            ->willReturnCallback(static function (ErpOrderCancellationMailConfigTransfer $configTransfer) use ($self) {
                $self->assertEquals($configTransfer->getType(), NotifyApprovedErpOrderCancellationMailTypePlugin::MAIL_TYPE);

                return $self->erpOrderCancellationMailConfigResponseTransferMock;
            });

        $this->assertSame($this->erpOrderCancellationResponseTransferMock, $this->plugin->postTransaction($this->erpOrderCancellationResponseTransferMock));
    }

    /**
     * @return void
     */
    public function testPostTransactionDoNothing(): void
    {
        $this->erpOrderCancellationResponseTransferMock->expects(static::once())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects(static::once())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->erpOrderCancellationTransferMock->expects(static::once())
            ->method('getState')
            ->willReturn('test');

        $this->facadeMock->expects(static::never())
            ->method('handleMails');

        $this->assertSame($this->erpOrderCancellationResponseTransferMock, $this->plugin->postTransaction($this->erpOrderCancellationResponseTransferMock));
    }
}
