<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyBusinessUnitToCompanyTransferExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyBusinessUnitToCompanyTransferExpander
     */
    protected CompanyBusinessUnitToCompanyTransferExpander $expander;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiRepository|MockObject $repositoryMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationCollectionTransfer|MockObject $companyUsersBulkPreparationCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCompanyBusinessUnitTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCompanyBusinessUnitTransfer|MockObject $companyBusinessUnitTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCompanyTransfer|MockObject $companyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationTransfer|MockObject $companyUsersBulkPreparationTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->repositoryMock = $this->getMockBuilder(CompanyUsersBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationCollectionTransferMock = $this->getMockBuilder(CompanyUsersBulkPreparationCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyUsersBulkCompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyUsersBulkCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationTransferMock = $this->getMockBuilder(CompanyUsersBulkPreparationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new CompanyBusinessUnitToCompanyTransferExpander($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $idCompany = 999;
        $idCompanyBusinessUnit = 22;
        $companyBusinessUnitCollection = [$idCompany => [$idCompanyBusinessUnit => $this->companyBusinessUnitTransferMock]];

        $companyBusinessUnitClone = clone $this->companyBusinessUnitTransferMock;

        $this->companyUsersBulkPreparationCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn([$this->companyUsersBulkPreparationTransferMock]);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $companyBusinessUnitClone
            ->expects(static::atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn(1);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyBusinessUnits')
            ->willReturn(new ArrayObject($companyBusinessUnitClone));

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyBusinessUnitsByIdCompany')
            ->willReturn($companyBusinessUnitCollection);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('addCompanyBusinessUnit')
            ->with($this->companyBusinessUnitTransferMock);

        $this->expander->expand($this->companyUsersBulkPreparationCollectionTransferMock);
    }
}
