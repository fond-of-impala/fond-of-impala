<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyRolesToCompanyTransferExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander\CompanyRolesToCompanyTransferExpander
     */
    protected CompanyRolesToCompanyTransferExpander $expander;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiRepository|MockObject $repositoryMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationCollectionTransfer|MockObject $companyUsersBulkPreparationCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCompanyRoleTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCompanyRoleTransfer|MockObject $companyRoleTransferMock;

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

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyUsersBulkCompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyUsersBulkCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationTransferMock = $this->getMockBuilder(CompanyUsersBulkPreparationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new CompanyRolesToCompanyTransferExpander($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $idCompany = 999;
        $idCompanyRole = 22;
        $companyRolesCollection = [$idCompany => [$idCompanyRole => $this->companyRoleTransferMock]];

        $companyRoleClone = clone $this->companyRoleTransferMock;

        $this->companyUsersBulkPreparationCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn([$this->companyUsersBulkPreparationTransferMock]);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyOrFail')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $companyRoleClone
            ->expects(static::atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn(1);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyRoles')
            ->willReturn(new ArrayObject($companyRoleClone));

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyRolesByCompanyIds')
            ->willReturn($companyRolesCollection);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('addCompanyRole')
            ->with($this->companyRoleTransferMock);

        $this->expander->expand($this->companyUsersBulkPreparationCollectionTransferMock);
    }
}
