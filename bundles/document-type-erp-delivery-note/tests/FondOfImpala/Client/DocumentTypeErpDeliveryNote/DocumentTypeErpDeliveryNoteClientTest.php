<?php

namespace FondOfImpala\Client\DocumentTypeErpDeliveryNote;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed\DocumentTypeErpDeliveryNoteStubInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DocumentTypeErpDeliveryNoteClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|DocumentTypeErpDeliveryNoteFactory $factoryMock;

    /**
     * @var \Generated\Shared\Transfer\DocumentRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected DocumentRequestTransfer|MockObject $documentRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\EasyApiFilterTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EasyApiFilterTransfer|MockObject $easyApiFilterTransferMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed\DocumentTypeErpDeliveryNoteStubInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected DocumentTypeErpDeliveryNoteStubInterface|MockObject $zedStubMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteClient
     */
    protected DocumentTypeErpDeliveryNoteClient $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->easyApiFilterTransferMock = $this->getMockBuilder(EasyApiFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new DocumentTypeErpDeliveryNoteClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGetFilterTransfer(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedDocumentTypeErpDeliveryNoteStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('getFilterTransfer')
            ->with($this->documentRequestTransferMock)
            ->willReturn($this->easyApiFilterTransferMock);

        static::assertEquals(
            $this->easyApiFilterTransferMock,
            $this->client->getFilterTransfer(
                $this->documentRequestTransferMock,
            ),
        );
    }
}
