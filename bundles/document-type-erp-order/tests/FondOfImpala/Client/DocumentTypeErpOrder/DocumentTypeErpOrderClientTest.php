<?php

namespace FondOfImpala\Client\DocumentTypeErpOrder;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpOrder\Zed\DocumentTypeErpOrderStubInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DocumentTypeErpOrderClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\DocumentTypeErpOrder\DocumentTypeErpOrderFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|DocumentTypeErpOrderFactory $factoryMock;

    /**
     * @var \Generated\Shared\Transfer\DocumentRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected DocumentRequestTransfer|MockObject $documentRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\EasyApiFilterTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EasyApiFilterTransfer|MockObject $easyApiFilterTransferMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpOrder\Zed\DocumentTypeErpOrderStubInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected DocumentTypeErpOrderStubInterface|MockObject $zedStubMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpOrder\DocumentTypeErpOrderClient
     */
    protected DocumentTypeErpOrderClient $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(DocumentTypeErpOrderFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->easyApiFilterTransferMock = $this->getMockBuilder(EasyApiFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(DocumentTypeErpOrderStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new DocumentTypeErpOrderClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGetFilterTransfer(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedDocumentTypeErpOrderStub')
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
