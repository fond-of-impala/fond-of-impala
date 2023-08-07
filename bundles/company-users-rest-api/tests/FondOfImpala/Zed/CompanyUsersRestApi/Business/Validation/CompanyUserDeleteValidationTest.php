<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserDeleteValidationTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\CompanyUserDeleteValidation
     */
    protected CompanyUserDeleteValidation $validation;

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
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestDeleteCompanyUserRequestTransfer|MockObject $restDeleteCompanyUserRequestTransferMock;

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

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validation = new CompanyUserDeleteValidation(
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

        static::assertFalse($this->validation->validate($this->companyUserTransferMock, $this->restDeleteCompanyUserRequestTransferMock));
    }

    /**
     * @return void
     */
    public function testValidateWithRoleIsProtected(): void
    {
        $protectedRole = 'admin';
        $unProtectedRole = 'distributor';

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserByFkCompany')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserRolesByCompanyUser')
            ->willReturn([$unProtectedRole, $protectedRole]);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn(99);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getProtectedRoles')
            ->willReturn([$protectedRole]);

        $this->companyUserCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransferMock, $this->companyUserTransferMock]));

        static::assertFalse($this->validation->validate($this->companyUserTransferMock, $this->restDeleteCompanyUserRequestTransferMock));
    }

    /**
     * @return void
     */
    public function testValidatePreventDeletingOwnCompanyUser(): void
    {
        $protectedRole = 'admin';
        $unProtectedRole = 'distributor';
        $idCustomer = 44;

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserByFkCompany')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserRolesByCompanyUser')
            ->willReturn([$unProtectedRole]);

        $this->restDeleteCompanyUserRequestTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn(99);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($idCustomer);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getProtectedRoles')
            ->willReturn([$protectedRole]);

        $this->companyUserCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransferMock, $this->companyUserTransferMock]));

        static::assertFalse($this->validation->validate($this->companyUserTransferMock, $this->restDeleteCompanyUserRequestTransferMock));
    }

    /**
     * @return void
     */
    public function testValidateCanDelete(): void
    {
        $protectedRole = 'admin';
        $unProtectedRole = 'distributor';
        $idCustomer = 44;

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserByFkCompany')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUserRolesByCompanyUser')
            ->willReturn([$unProtectedRole]);

        $this->restDeleteCompanyUserRequestTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->companyUserTransferMock2
            ->expects(static::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn(99);

        $this->companyUserTransferMock2
            ->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn(99);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($idCustomer);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getProtectedRoles')
            ->willReturn([$protectedRole]);

        $this->companyUserCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransferMock2, $this->companyUserTransferMock]));

        static::assertTrue($this->validation->validate($this->companyUserTransferMock2, $this->restDeleteCompanyUserRequestTransferMock));
    }
}
