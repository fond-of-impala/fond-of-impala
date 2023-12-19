<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyRoleDeleterTest extends Unit
{
    protected CompanyTypeRoleToCompanyRoleFacadeInterface|MockObject $companyRoleFacadeMock;

    protected CompanyTypeRoleToCompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    protected CompanyTypeRoleRepositoryInterface|MockObject $repositoryMock;

    protected CompanyRoleTransfer|MockObject $companyRoleTransferMock;

    protected CompanyRoleResponseTransfer|MockObject $companyRoleResponseTransferMock;

    protected CompanyUserCollectionTransfer|MockObject $companyUserCollectionTransferMock;

    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    protected CompanyRoleDeleter $companyRoleDeleter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyTypeRoleRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleDeleter = new CompanyRoleDeleter(
            $this->companyUserFacadeMock,
            $this->companyRoleFacadeMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyRoleAndCompanyUserByCompanyRoleWithNoCompanyUserToDelete(): void
    {
        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn(1);

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyUserIdsByCompanyRoleId')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject());

        $this->companyUserFacadeMock->expects($this->never())
            ->method('deleteCompanyUser');

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('delete')->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleDeleter
            ->deleteCompanyRoleAndCompanyUserByCompanyRole($this->companyRoleTransferMock);
    }

    /**
     * @return void
     */
    public function testDeleteCompanyRoleAndCompanyUserByCompanyRole(): void
    {
        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn(1);

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyUserIdsByCompanyRoleId')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransferMock]));

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->companyUserTransferMock);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('delete')->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleDeleter
            ->deleteCompanyRoleAndCompanyUserByCompanyRole($this->companyRoleTransferMock);
    }
}
