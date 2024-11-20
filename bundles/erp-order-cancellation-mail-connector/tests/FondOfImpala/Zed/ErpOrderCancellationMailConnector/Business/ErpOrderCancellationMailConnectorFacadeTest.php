<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail\MailHandlerInterface;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationMailConnectorFacadeTest extends Unit
{
    protected MockObject|ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransferMock;

    protected MockObject|ErpOrderCancellationMailConfigResponseTransfer $erpOrderCancellationMailConfigResponseTransferMock;

    protected MockObject|ErpOrderCancellationMailConnectorBusinessFactory $factoryMock;

    protected MockObject|MailHandlerInterface $mailHandlerMock;

    protected ErpOrderCancellationMailConnectorFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationMailConfigResponseTransferMock = $this->getMockBuilder(ErpOrderCancellationMailConfigResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationMailConfigTransferMock = $this->getMockBuilder(ErpOrderCancellationMailConfigTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailHandlerMock = $this->getMockBuilder(MailHandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ErpOrderCancellationMailConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testHandleMails(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createMailHandler')
            ->willReturn($this->mailHandlerMock);

        $this->mailHandlerMock->expects(static::atLeastOnce())
            ->method('sendMail')
            ->with($this->erpOrderCancellationMailConfigTransferMock)
            ->willReturn($this->erpOrderCancellationMailConfigResponseTransferMock);

        $responseTransfer = $this->facade->handleMails($this->erpOrderCancellationMailConfigTransferMock);

        static::assertEquals($this->erpOrderCancellationMailConfigResponseTransferMock, $responseTransfer);
    }
}
