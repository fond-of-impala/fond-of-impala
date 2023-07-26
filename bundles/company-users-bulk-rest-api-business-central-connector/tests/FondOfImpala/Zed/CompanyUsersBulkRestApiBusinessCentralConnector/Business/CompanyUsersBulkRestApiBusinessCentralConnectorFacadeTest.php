<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\Expander\CompanyDebtorNumberExpander;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUsersBulkRestApiBusinessCentralConnectorFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\CompanyUsersBulkRestApiBusinessCentralConnectorFacade
     */
    protected CompanyUsersBulkRestApiBusinessCentralConnectorFacade $facade;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\CompanyUsersBulkRestApiBusinessCentralConnectorBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiBusinessCentralConnectorBusinessFactory|MockObject $factoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\Expander\CompanyDebtorNumberExpander|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyDebtorNumberExpander|MockObject $expanderMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationCollectionTransfer|MockObject $companyUsersBulkPreparationCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(CompanyUsersBulkRestApiBusinessCentralConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expanderMock = $this
            ->getMockBuilder(CompanyDebtorNumberExpander::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationCollectionTransferMock = $this
            ->getMockBuilder(CompanyUsersBulkPreparationCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyUsersBulkRestApiBusinessCentralConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandWithCompanyDebtorNumber(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyDebtorNumberExpander')
            ->willReturn($this->expanderMock);

        $this->expanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->companyUsersBulkPreparationCollectionTransferMock)
            ->willReturn($this->companyUsersBulkPreparationCollectionTransferMock);

        $this->facade->expandWithCompanyDebtorNumber(
            $this->companyUsersBulkPreparationCollectionTransferMock,
        );
    }
}
