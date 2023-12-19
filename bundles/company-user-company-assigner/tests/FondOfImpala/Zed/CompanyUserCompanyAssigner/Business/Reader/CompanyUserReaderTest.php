<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleNameMapperMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyTypeTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleNameMapperMock = $this->getMockBuilder(CompanyRoleNameMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReader = new CompanyUserReader(
            $this->companyRoleNameMapperMock,
            $this->companyTypeFacadeMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testFindWithInconsistentCompanyRolesByManufacturerUser(): void
    {
        $idCustomer = 1;
        $companyRoleName = 'foo';
        $idCompanyType = 1;
        $companyIds = [1, 2, 4, 5];
        $nonManufacturerUsers = [
            3 => [
                'id_company_user' => 3,
                'id_company' => 1,
                'company_roles' => ['foo'],
            ],
        ];

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($idCustomer);

        $this->companyRoleNameMapperMock->expects(static::atLeastOnce())
            ->method('fromManufacturerUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($companyRoleName);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('getManufacturerCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn($idCompanyType);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyIdsByIdCustomerAndIdCompanyType')
            ->with($idCompanyType, $idCompanyType)
            ->willReturn($companyIds);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findNonManufacturerUsersWithInconsistentCompanyRoles')
            ->with($idCustomer, $companyRoleName, $companyIds)
            ->willReturn($nonManufacturerUsers);

        static::assertEquals(
            $nonManufacturerUsers,
            $this->companyUserReader->findWithInconsistentCompanyRolesByManufacturerUser(
                $this->companyUserTransferMock,
            ),
        );
    }
}
