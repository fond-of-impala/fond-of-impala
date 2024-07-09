<?php

namespace FondOfImpala\Glue\DocumentTypeErpDeliveryNote\Dependency\Plugin\DocumentsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteClient;
use FondOfImpala\Glue\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteFactory;
use FondOfImpala\Glue\DocumentTypeErpDeliveryNote\Model\Mapper\RequestMapperInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\DocumentRestRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpDeliveryNoteDocumentTypePluginTest extends Unit
{
    protected DocumentTypeErpDeliveryNoteFactory|MockObject $factoryMock;

    protected DocumentTypeErpDeliveryNoteClient|MockObject $clientMock;

    protected RequestMapperInterface|MockObject $requestMapperMock;

    protected EasyApiFilterTransfer|MockObject $easyApiFilterTransferMock;

    protected DocumentRequestTransfer|MockObject $documentRequestTransferMock;

    protected DocumentRestRequestTransfer|MockObject $documentRestRequestTransferMock;

    protected ErpDeliveryNoteDocumentTypePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteClient::class)
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

        $this->plugin = new ErpDeliveryNoteDocumentTypePlugin();
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
