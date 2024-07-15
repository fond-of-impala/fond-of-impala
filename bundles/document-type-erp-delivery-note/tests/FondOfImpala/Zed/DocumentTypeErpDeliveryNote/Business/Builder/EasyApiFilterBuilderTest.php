<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\Builder;

use Codeception\Test\Unit;
use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteConfig;
use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence\DocumentTypeErpDeliveryNoteRepositoryInterface;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpDeliveryNoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class EasyApiFilterBuilderTest extends Unit
{
    protected MockObject|DocumentTypeErpDeliveryNoteConfig $configMock;

    protected MockObject|DocumentTypeErpDeliveryNoteRepositoryInterface $repositoryMock;

    protected MockObject|DocumentRequestTransfer $documentRequestTransferMock;

    protected MockObject|ErpDeliveryNoteTransfer $erpOrderTransferMock;

    protected EasyApiFilterBuilder $builder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->documentRequestTransferMock = $this->getMockBuilder(DocumentRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderTransferMock = $this->getMockBuilder(ErpDeliveryNoteTransfer::class)
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
            ->method('getErpDeliveryNoteWithPermissionCheck')
            ->with($this->documentRequestTransferMock)
            ->willReturn($this->erpOrderTransferMock);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getEasyApiStore')
            ->willReturn('store');

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryNoteNumber')
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
