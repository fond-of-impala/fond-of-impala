<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ManufacturerUserAssignerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleNameMapperMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserMapperMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected MockObject|CompanyUserCompanyAssignerConfig $configMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $companyUserTransferMocks;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssigner
     */
    protected $manufacturerUserAssigner;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleNameMapperMock = $this->getMockBuilder(CompanyRoleNameMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserMapperMock = $this->getMockBuilder(CompanyUserMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyUserCompanyAssignerConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMocks = [
            $this->getMockBuilder(CompanyUserTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->manufacturerUserAssigner = new ManufacturerUserAssigner(
            $this->companyRoleNameMapperMock,
            $this->companyUserMapperMock,
            $this->repositoryMock,
            $this->companyTypeFacadeMock,
            $this->companyUserFacadeMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testAssignToNonManufacturerCompanies(): void
    {
        $idCompanyUser = 1;
        $idCustomer = 1;
        $companyTypeName = 'manufacturer';
        $companyRoleName = 'administration';
        $nonManufacturerData = [
            [
                'id_company' => 1,
                'id_company_business_unit' => 1,
                'id_company_role' => 1,
            ],
        ];

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($idCustomer);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeNameByIdCompanyUser')
            ->with($idCompanyUser)
            ->willReturn($companyTypeName);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturn($companyTypeName);

        $this->companyRoleNameMapperMock->expects(static::atLeastOnce())
            ->method('fromManufacturerUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($companyRoleName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getValidManufacturerCompanyRolesForAssignment')
            ->willReturn([$companyRoleName]);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findNonManufacturerData')
            ->with($companyTypeName, $companyRoleName)
            ->willReturn($nonManufacturerData);

        $this->companyUserMapperMock->expects(static::atLeastOnce())
            ->method('fromNonManufacturerData')
            ->with($nonManufacturerData)
            ->willReturn($this->companyUserTransferMocks);

        $this->companyUserTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setFkCustomer')
            ->with($idCustomer)
            ->willReturn($this->companyUserTransferMocks[0]);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->companyUserTransferMocks[0]->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserTransferMocks[0]);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->companyUserTransferMocks[0]);

        $this->manufacturerUserAssigner->assignToNonManufacturerCompanies($this->companyUserTransferMock);
    }

    /**
     * @return void
     */
    public function testAssignToNonManufacturerCompaniesWithoutIdCompanyUser(): void
    {
        $idCompanyUser = null;
        $idCustomer = 1;

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($idCustomer);

        $this->repositoryMock->expects(static::never())
            ->method('findCompanyTypeNameByIdCompanyUser');

        $this->companyTypeFacadeMock->expects(static::never())
            ->method('getCompanyTypeManufacturerName');

        $this->companyRoleNameMapperMock->expects(static::never())
            ->method('fromManufacturerUser');

        $this->repositoryMock->expects(static::never())
            ->method('findNonManufacturerData');

        $this->companyUserMapperMock->expects(static::never())
            ->method('fromNonManufacturerData');

        $this->companyUserTransferMock->expects(static::never())
            ->method('getCustomer');

        $this->companyUserFacadeMock->expects(static::never())
            ->method('create');

        $this->manufacturerUserAssigner->assignToNonManufacturerCompanies($this->companyUserTransferMock);
    }

    /**
     * @return void
     */
    public function testAssignToNonManufacturerCompaniesWithInvalidCompanyTypeName(): void
    {
        $idCompanyUser = 1;
        $idCustomer = 1;
        $companyTypeName = 'manufacturer';

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($idCustomer);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeNameByIdCompanyUser')
            ->with($idCompanyUser)
            ->willReturn('foo');

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturn($companyTypeName);

        $this->companyRoleNameMapperMock->expects(static::never())
            ->method('fromManufacturerUser');

        $this->repositoryMock->expects(static::never())
            ->method('findNonManufacturerData');

        $this->companyUserMapperMock->expects(static::never())
            ->method('fromNonManufacturerData');

        $this->companyUserTransferMock->expects(static::never())
            ->method('getCustomer');

        $this->companyUserFacadeMock->expects(static::never())
            ->method('create');

        $this->manufacturerUserAssigner->assignToNonManufacturerCompanies($this->companyUserTransferMock);
    }

    /**
     * @return void
     */
    public function testAssignToNonManufacturerCompaniesWithInvalidCompanyRoleName(): void
    {
        $idCompanyUser = 1;
        $idCustomer = 1;
        $companyTypeName = 'manufacturer';
        $companyRoleName = null;

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($idCustomer);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeNameByIdCompanyUser')
            ->with($idCompanyUser)
            ->willReturn($companyTypeName);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturn($companyTypeName);

        $this->companyRoleNameMapperMock->expects(static::atLeastOnce())
            ->method('fromManufacturerUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($companyRoleName);

        $this->repositoryMock->expects(static::never())
            ->method('findNonManufacturerData');

        $this->companyUserMapperMock->expects(static::never())
            ->method('fromNonManufacturerData');

        $this->companyUserTransferMock->expects(static::never())
            ->method('getCustomer');

        $this->companyUserFacadeMock->expects(static::never())
            ->method('create');

        $this->manufacturerUserAssigner->assignToNonManufacturerCompanies($this->companyUserTransferMock);
    }
}
