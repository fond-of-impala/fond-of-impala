<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\DocumentTypeErpInvoice\Business\Builder\EasyApiFilterBuilderInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DocumentTypeErpInvoiceFacadeTest extends Unit
{
    protected DocumentTypeErpInvoiceBusinessFactory|MockObject $factoryMock;

    protected EasyApiFilterBuilderInterface|MockObject $easyApiFilterBuilderMock;

    protected MockObject|EasyApiFilterTransfer $easyApiFilterTransferMock;

    protected MockObject|DocumentRequestTransfer $documentRequestTransferMock;

    protected DocumentTypeErpInvoiceFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(DocumentTypeErpInvoiceBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->easyApiFilterTransferMock = $this->getMockBuilder(EasyApiFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->easyApiFilterBuilderMock = $this->getMockBuilder(EasyApiFilterBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new DocumentTypeErpInvoiceFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGetFilter(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createEasyApiFilterBuilder')
            ->willReturn($this->easyApiFilterBuilderMock);

        $this->easyApiFilterBuilderMock->expects(static::atLeastOnce())
            ->method('build')
            ->with($this->documentRequestTransferMock)
            ->willReturn($this->easyApiFilterTransferMock);

        static::assertEquals(
            $this->easyApiFilterTransferMock,
            $this->facade->getFilter($this->documentRequestTransferMock),
        );
    }
}
