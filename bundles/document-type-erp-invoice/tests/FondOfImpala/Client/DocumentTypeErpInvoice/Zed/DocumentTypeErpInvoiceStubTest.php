<?php

namespace FondOfImpala\Client\DocumentTypeErpInvoice\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class DocumentTypeErpInvoiceStubTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\DocumentRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected DocumentRequestTransfer|MockObject $documentRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\EasyApiFilterTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EasyApiFilterTransfer|MockObject $easyApiFilterTransferMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|DocumentTypeErpInvoiceToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpInvoice\Zed\DocumentTypeErpInvoiceStub
     */
    protected DocumentTypeErpInvoiceStub $stub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->easyApiFilterTransferMock = $this->getMockBuilder(EasyApiFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(DocumentTypeErpInvoiceToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->stub = new DocumentTypeErpInvoiceStub(
            $this->zedRequestClientMock,
        );
    }

    /**
     * @return void
     */
    public function testGetFilterTransfer(): void
    {
        $self = $this;
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                DocumentTypeErpInvoiceStub::URL_GET_FILTER,
                $this->documentRequestTransferMock,
            )->willReturnCallback(static function (string $url, AbstractTransfer $transfer) use ($self) {
                static::assertEquals(
                    DocumentTypeErpInvoiceStub::URL_GET_FILTER,
                    $url,
                );

                static::assertEquals(
                    $self->documentRequestTransferMock,
                    $transfer,
                );

                return $self->easyApiFilterTransferMock;
            });

        static::assertEquals(
            $this->easyApiFilterTransferMock,
            $this->stub->getFilterTransfer(
                $this->documentRequestTransferMock,
            ),
        );
    }
}
