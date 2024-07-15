<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Business\Builder;

use Codeception\Test\Unit;
use FondOfImpala\Zed\DocumentTypeErpInvoice\DocumentTypeErpInvoiceConfig;
use FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence\DocumentTypeErpInvoiceRepositoryInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpInvoiceTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class EasyApiFilterBuilderTest extends Unit
{
    protected MockObject|DocumentTypeErpInvoiceConfig $configMock;

    protected MockObject|DocumentTypeErpInvoiceRepositoryInterface $repositoryMock;

    protected MockObject|DocumentRequestTransfer $documentRequestTransferMock;

    protected MockObject|ErpInvoiceTransfer $erpOrderTransferMock;

    protected EasyApiFilterBuilder $builder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(DocumentTypeErpInvoiceConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(DocumentTypeErpInvoiceRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderTransferMock = $this->getMockBuilder(ErpInvoiceTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->builder = new EasyApiFilterBuilder(
            $this->repositoryMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getErpInvoiceWithPermissionCheck')
            ->with($this->documentRequestTransferMock)
            ->willReturn($this->erpOrderTransferMock);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getEasyApiStore')
            ->willReturn('store');

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getDocumentNumber')
            ->willReturn('ref');

        $toTest = $this->builder->build(
            $this->documentRequestTransferMock,
        );

        static::assertInstanceOf(
            EasyApiFilterTransfer::class,
            $toTest,
        );

        static::assertEquals(
            ['store'],
            $toTest->getStores(),
        );

        static::assertEquals(
            'ref',
            $toTest->getConditions()->offsetGet(0)->getValue(),
        );
    }
}
