<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToCompanyUserTableMap;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserUpdateValidationTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\CompanyUserUpdateValidation
     */
    protected CompanyUserUpdateValidation $validation;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersRestApiRepositoryInterface|MockObject $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersRestApiConfig|MockObject $configMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock2;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestWriteCompanyUserRequestTransfer|MockObject $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCollectionTransfer|MockObject $companyUserCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->repositoryMock = $this->getMockBuilder(CompanyUsersRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyUsersRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock2 = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validation = new CompanyUserUpdateValidation(
            $this->repositoryMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testValidateWithOnlyOneCompanyUserFound(): void
    {
        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserByFkCompany')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn(99);

        $this->companyUserCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransferMock]));

        static::assertFalse($this->validation->validate($this->companyUserTransferMock, $this->restWriteCompanyUserRequestTransferMock));
    }

    /**
     * @return void
     */
    public function testValidateWithRoleIsProtected(): void
    {
        $protectedRoleName = 'admin';
        $unProtectedRoleName = 'distributor';
        $protectedRole = [
            SpyCompanyRoleTableMap::COL_NAME => $protectedRoleName,
            SpyCompanyRoleTableMap::COL_UUID => 'asdasdas',
            SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER => 99,
        ];
        $unProtectedRole = [
            SpyCompanyRoleTableMap::COL_NAME => $unProtectedRoleName,
            SpyCompanyRoleTableMap::COL_UUID => 'asdasasdasdadas',
            SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER => 2,
        ];

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserByFkCompany')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserRolesByFkCompany')
            ->willReturn([$unProtectedRole, $protectedRole]);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn(99);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn(99);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getProtectedRoles')
            ->willReturn([$protectedRoleName]);

        $this->companyUserCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransferMock, $this->companyUserTransferMock]));

        static::assertFalse($this->validation->validate($this->companyUserTransferMock, $this->restWriteCompanyUserRequestTransferMock));
    }

    /**
     * @return void
     */
    public function testValidateCanUpdate(): void
    {
        $protectedRoleName = 'admin';
        $unProtectedRoleName = 'distributor';
        $protectedRole = [
            SpyCompanyRoleTableMap::COL_NAME => $protectedRoleName,
            SpyCompanyRoleTableMap::COL_UUID => 'asdasdas',
            SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER => 1,
        ];
        $unProtectedRole = [
            SpyCompanyRoleTableMap::COL_NAME => $unProtectedRoleName,
            SpyCompanyRoleTableMap::COL_UUID => 'asdasasdasdadas',
            SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER => 99,
        ];

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserByFkCompany')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserRolesByFkCompany')
            ->willReturn([$unProtectedRole, $protectedRole]);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn(99);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn(99);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getProtectedRoles')
            ->willReturn([$protectedRoleName]);

        $this->companyUserCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransferMock, $this->companyUserTransferMock]));

        static::assertTrue($this->validation->validate($this->companyUserTransferMock, $this->restWriteCompanyUserRequestTransferMock));
    }
}
