<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Business\Builder;

use Codeception\Test\Unit;
use FondOfImpala\Zed\DocumentTypeErpOrder\DocumentTypeErpOrderConfig;
use FondOfImpala\Zed\DocumentTypeErpOrder\Persistence\DocumentTypeErpOrderRepositoryInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpOrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class EasyApiFilterBuilderTest extends Unit
{
    protected MockObject|DocumentTypeErpOrderConfig $configMock;

    protected MockObject|DocumentTypeErpOrderRepositoryInterface $repositoryMock;

    protected MockObject|DocumentRequestTransfer $documentRequestTransferMock;

    protected MockObject|ErpOrderTransfer $erpOrderTransferMock;

    protected EasyApiFilterBuilder $builder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(DocumentTypeErpOrderConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(DocumentTypeErpOrderRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderTransferMock = $this->getMockBuilder(ErpOrderTransfer::class)
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
            ->method('getErpOrderWithPermissionCheck')
            ->with($this->documentRequestTransferMock)
            ->willReturn($this->erpOrderTransferMock);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getEasyApiStore')
            ->willReturn('store');

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getExternalReference')
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
