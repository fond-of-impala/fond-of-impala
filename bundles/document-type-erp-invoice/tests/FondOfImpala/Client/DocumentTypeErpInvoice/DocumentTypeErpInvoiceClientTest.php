<?php

namespace FondOfImpala\Client\DocumentTypeErpInvoice;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpInvoice\Zed\DocumentTypeErpInvoiceStubInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DocumentTypeErpInvoiceClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\DocumentTypeErpInvoice\DocumentTypeErpInvoiceFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|DocumentTypeErpInvoiceFactory $factoryMock;

    /**
     * @var \Generated\Shared\Transfer\DocumentRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected DocumentRequestTransfer|MockObject $documentRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\EasyApiFilterTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EasyApiFilterTransfer|MockObject $easyApiFilterTransferMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpInvoice\Zed\DocumentTypeErpInvoiceStubInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected DocumentTypeErpInvoiceStubInterface|MockObject $zedStubMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpInvoice\DocumentTypeErpInvoiceClient
     */
    protected DocumentTypeErpInvoiceClient $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(DocumentTypeErpInvoiceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->easyApiFilterTransferMock = $this->getMockBuilder(EasyApiFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(DocumentTypeErpInvoiceStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new DocumentTypeErpInvoiceClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGetFilterTransfer(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedDocumentTypeErpInvoiceStub')
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
