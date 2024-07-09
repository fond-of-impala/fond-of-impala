<?php

namespace FondOfImpala\Glue\DocumentTypeErpInvoice\Dependency\Plugin\DocumentsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpInvoice\DocumentTypeErpInvoiceClient;
use FondOfImpala\Glue\DocumentTypeErpInvoice\DocumentTypeErpInvoiceFactory;
use FondOfImpala\Glue\DocumentTypeErpInvoice\Model\Mapper\RequestMapperInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\DocumentRestRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpInvoiceDocumentTypePluginTest extends Unit
{
    protected DocumentTypeErpInvoiceFactory|MockObject $factoryMock;

    protected DocumentTypeErpInvoiceClient|MockObject $clientMock;

    protected RequestMapperInterface|MockObject $requestMapperMock;

    protected EasyApiFilterTransfer|MockObject $easyApiFilterTransferMock;

    protected DocumentRequestTransfer|MockObject $documentRequestTransferMock;

    protected DocumentRestRequestTransfer|MockObject $documentRestRequestTransferMock;

    protected ErpInvoiceDocumentTypePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(DocumentTypeErpInvoiceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(DocumentTypeErpInvoiceClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMapperMock = $this->getMockBuilder(RequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->easyApiFilterTransferMock = $this->getMockBuilder(EasyApiFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRestRequestTransferMock = $this->getMockBuilder(DocumentRestRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ErpInvoiceDocumentTypePlugin();
        $this->plugin->setClient($this->clientMock);
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCreateEasyApiFilter(): void
    {
        $this->clientMock->expects(static::atLeastOnce())
            ->method('getFilterTransfer')
            ->willReturn($this->easyApiFilterTransferMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createRequestMapper')
            ->willReturn($this->requestMapperMock);

        $this->requestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->willReturn($this->documentRequestTransferMock);

        static::assertEquals(
            $this->easyApiFilterTransferMock,
            $this->plugin->createEasyApiFilter(
                $this->documentRestRequestTransferMock,
            ),
        );
    }
}
