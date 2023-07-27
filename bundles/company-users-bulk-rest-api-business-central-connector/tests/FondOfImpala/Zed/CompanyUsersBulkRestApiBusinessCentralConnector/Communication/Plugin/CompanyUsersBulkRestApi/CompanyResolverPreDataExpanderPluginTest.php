<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Communication\Plugin\CompanyUsersBulkRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\CompanyUsersBulkRestApiBusinessCentralConnectorFacade;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyResolverPreDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Communication\Plugin\CompanyUsersBulkRestApi\CompanyDebtorNumberResolverPreDataExpanderPlugin
     */
    protected CompanyDebtorNumberResolverPreDataExpanderPlugin $plugin;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\CompanyUsersBulkRestApiBusinessCentralConnectorFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiBusinessCentralConnectorFacade|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationCollectionTransfer|MockObject $companyUsersBulkPreparationCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(CompanyUsersBulkRestApiBusinessCentralConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationCollectionTransferMock = $this->getMockBuilder(CompanyUsersBulkPreparationCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CompanyDebtorNumberResolverPreDataExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facadeMock
            ->expects(static::atLeastOnce())
            ->method('expandWithCompanyDebtorNumber')
            ->willReturn($this->companyUsersBulkPreparationCollectionTransferMock);

        $this->plugin->expand($this->companyUsersBulkPreparationCollectionTransferMock);
    }
}
