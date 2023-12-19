<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

class CompanyUserTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser
     */
    protected $companyUser;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected $companyUserCompanyAssignerConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface
     */
    protected $companyUserCompanyAssignerRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    protected $companyTypeResponseTransferMock;

    /**
     * @var string
     */
    protected $companyTypeName;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    protected $companyTypeCollectionTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\CompanyTypeTransfer>
     */
    protected $companyTypeTransferMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    protected $companyCollectionTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\CompanyTransfer>
     */
    protected $companyTransferMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\CompanyRoleTransfer>
     */
    protected $companyRoleTransferMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $customerTransferMock;

    /**
     * @var int
     */
    protected $idCustomer;

    /**
     * @var int
     */
    protected $idCompanyBusinessUnit;

    /**
     * @var string
     */
    protected $companyRoleName;

    /**
     * @var array
     */
    protected $companyTypeRoleMapping;

    /**
     * @var string
     */
    protected $companyRoleConfigName;

    /**
     * @var int
     */
    protected $idCompanyType;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \ArrayObject<\Generated\Shared\Transfer\CompanyUserTransfer>
     */
    protected $companyUserTransferMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserCompanyAssignerConfigMock = $this->getMockBuilder(CompanyUserCompanyAssignerConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerRepositoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompany = 1;

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeResponseTransferMock = $this->getMockBuilder(CompanyTypeResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeName = 'company-type-name';

        $this->companyTypeCollectionTransferMock = $this->getMockBuilder(CompanyTypeCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMocks = new ArrayObject([
            $this->companyTypeTransferMock,
        ]);

        $this->companyCollectionTransferMock = $this->getMockBuilder(CompanyCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMocks = new ArrayObject([
            $this->companyTransferMock,
        ]);

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMocks = new ArrayObject([
            $this->companyRoleTransferMock,
        ]);

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCustomer = 2;

        $this->idCompanyBusinessUnit = 3;

        $this->companyRoleName = 'company-role-name';

        $this->companyRoleConfigName = 'company-role-config-name';

        $this->companyTypeRoleMapping = [
            $this->companyRoleName => $this->companyRoleConfigName,
        ];

        $this->idCompanyType = 4;

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMocks = new ArrayObject([
            $this->companyUserTransferMock,
        ]);

        $this->companyUser = new CompanyUser(
            $this->companyUserCompanyAssignerConfigMock,
            $this->companyUserCompanyAssignerRepositoryMock,
            $this->companyUserFacadeMock,
            $this->companyFacadeMock,
            $this->companyTypeFacadeMock,
            $this->companyRoleFacadeMock,
            $this->companyBusinessUnitFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompanies(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->companyTypeName);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturn($this->companyTypeName);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $this->companyTypeCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeTransferMocks);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompaniesByCompanyTypeIds')
            ->willReturn($this->companyCollectionTransferMock);

        $this->companyCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanies')
            ->willReturn($this->companyTransferMocks);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($this->companyRoleTransferMocks);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->with($this->idCompany)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($this->idCustomer);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($this->idCompanyBusinessUnit);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleById')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->companyRoleName);

        $this->companyUserCompanyAssignerConfigMock->expects($this->atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn($this->companyTypeRoleMapping);

        $this->companyUserCompanyAssignerRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleTransferByIdCompanyAndCompanyRoleName')
            ->with($this->idCompany, $this->companyRoleConfigName)
            ->willReturn($this->companyRoleTransferMock);

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUser->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompaniesCompanyUserNull(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUser->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompaniesCompanyTransferNull(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn(null);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUser->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompaniesCompanyTypeNull(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUser->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompaniesIsNotManufacturer(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->companyTypeName);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturn('');

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUser->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompaniesCompanyCollectionNull(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->companyTypeName);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturn($this->companyTypeName);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $this->companyTypeCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeTransferMocks);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompaniesByCompanyTypeIds')
            ->willReturn(null);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUser->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompaniesIsNotManufacturerSecond(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                $this->companyTypeName,
                $this->companyTypeName,
            );

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturnOnConsecutiveCalls(
                $this->companyTypeName,
                '',
            );

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $this->companyTypeCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeTransferMocks);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompaniesByCompanyTypeIds')
            ->willReturn($this->companyCollectionTransferMock);

        $this->companyCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanies')
            ->willReturn($this->companyTransferMocks);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($this->companyRoleTransferMocks);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->with($this->idCompany)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($this->idCustomer);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($this->idCompanyBusinessUnit);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleById')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->companyRoleName);

        $this->companyUserCompanyAssignerConfigMock->expects($this->atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn($this->companyTypeRoleMapping);

        $this->companyUserCompanyAssignerRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleTransferByIdCompanyAndCompanyRoleName')
            ->with($this->idCompany, $this->companyRoleConfigName)
            ->willReturn($this->companyRoleTransferMock);

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUser->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompaniesCompanyRoleNull(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->companyTypeName);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturn($this->companyTypeName);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $this->companyTypeCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeTransferMocks);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompaniesByCompanyTypeIds')
            ->willReturn($this->companyCollectionTransferMock);

        $this->companyCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanies')
            ->willReturn($this->companyTransferMocks);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($this->companyRoleTransferMocks);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->with($this->idCompany)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleById')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->companyRoleName);

        $this->companyUserCompanyAssignerConfigMock->expects($this->atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn($this->companyTypeRoleMapping);

        $this->companyUserCompanyAssignerRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleTransferByIdCompanyAndCompanyRoleName')
            ->with($this->idCompany, $this->companyRoleConfigName)
            ->willReturn(null);

        $this->companyUserTransferMock->expects($this->never())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->companyUserTransferMock->expects($this->never())
            ->method('getFkCustomer')
            ->willReturn($this->idCustomer);

        $this->companyBusinessUnitTransferMock->expects($this->never())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($this->idCompanyBusinessUnit);

        $this->companyUserFacadeMock->expects($this->never())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUser->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUsersToCompany(): void
    {
        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn(null);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturnOnConsecutiveCalls(
                '',
                $this->companyTypeName,
                $this->companyTypeName,
            );

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeByName')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompaniesByCompanyTypeIds')
            ->willReturn($this->companyCollectionTransferMock);

        $this->companyCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanies')
            ->willReturn($this->companyTransferMocks);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyUserCollection')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUserTransferMocks);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($this->companyRoleTransferMocks);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->with($this->idCompany)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($this->idCustomer);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($this->idCompanyBusinessUnit);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleById')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->companyRoleName);

        $this->companyUserCompanyAssignerConfigMock->expects($this->atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn($this->companyTypeRoleMapping);

        $this->companyUserCompanyAssignerRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleTransferByIdCompanyAndCompanyRoleName')
            ->with($this->idCompany, $this->companyRoleConfigName)
            ->willReturn($this->companyRoleTransferMock);

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $this->companyUser->addManufacturerUsersToCompany(
                $this->companyResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUsersToCompanyCompanyCollectionNull(): void
    {
        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn(null);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturnOnConsecutiveCalls(
                '',
                $this->companyTypeName,
                $this->companyTypeName,
            );

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeByName')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompaniesByCompanyTypeIds')
            ->willReturn(null);

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $this->companyUser->addManufacturerUsersToCompany(
                $this->companyResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUsersToCompanyCompanyTypeNull(): void
    {
        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn(null);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($this->idCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturnOnConsecutiveCalls(
                '',
                $this->companyTypeName,
                $this->companyTypeName,
            );

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeByName')
            ->willReturn(null);

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $this->companyUser->addManufacturerUsersToCompany(
                $this->companyResponseTransferMock,
            ),
        );
    }
}
