<?php

namespace FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class DocumentTypeErpDeliveryNoteStubTest extends Unit
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
     * @var \FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|DocumentTypeErpDeliveryNoteToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed\DocumentTypeErpDeliveryNoteStub
     */
    protected DocumentTypeErpDeliveryNoteStub $stub;

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

        $this->zedRequestClientMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->stub = new DocumentTypeErpDeliveryNoteStub(
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
                DocumentTypeErpDeliveryNoteStub::URL_GET_FILTER,
                $this->documentRequestTransferMock,
            )->willReturnCallback(static function (string $url, AbstractTransfer $transfer) use ($self) {
                static::assertEquals(
                    DocumentTypeErpDeliveryNoteStub::URL_GET_FILTER,
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
