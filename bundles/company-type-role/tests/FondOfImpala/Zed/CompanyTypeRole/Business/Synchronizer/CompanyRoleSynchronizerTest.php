<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\ResponseMessageTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyRoleSynchronizerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    protected $companyCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyTypeRoleRepositoryInterface|MockObject $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ResponseMessageTransfer
     */
    protected $responseMessageTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\CompanyRoleSynchronizer
     */
    protected $synchronizer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyTypeRoleRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCollectionTransferMock = $this->getMockBuilder(CompanyCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->responseMessageTransferMock = $this->getMockBuilder(ResponseMessageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->synchronizer = new CompanyRoleSynchronizer(
            $this->companyFacadeMock,
            $this->repositoryMock,
            $this->companyRoleFacadeMock,
            $this->companyTypeFacadeMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testSync(): void
    {
        $companies = new ArrayObject();
        $companies->append($this->companyTransferMock);
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);
        $companyTypeName = 'company-type';

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCount')
            ->willReturn(2);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCollection')
            ->willReturn($this->companyCollectionTransferMock);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCompanySyncChunkSize')
            ->willReturn(2);

        $this->companyCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn($companies);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(1);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeByIdCompany')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyTypeName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getPredefinedCompanyRolesByCompanyTypeName')
            ->with($companyTypeName)
            ->willReturn([$this->companyRoleTransferMock]);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyRoles);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'company-role',
                'company-role-delete',
                'company-role-delete',
                'company-role-delete',
                'company-role-add',
            );

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('delete')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturnOnConsecutiveCalls(true, true);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->synchronizer->sync();
    }

    /**
     * @return void
     */
    public function testSyncWithExceptionOnDelete(): void
    {
        $companies = new ArrayObject();
        $companies->append($this->companyTransferMock);
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);
        $responseErrorMessages = new ArrayObject();
        $responseErrorMessages->append($this->responseMessageTransferMock);
        $companyTypeName = 'company-type';

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCollection')
            ->willReturn($this->companyCollectionTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCount')
            ->willReturn(10);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCompanySyncChunkSize')
            ->willReturn(2);

        $this->companyCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn($companies);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(1);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeByIdCompany')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyTypeName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getPredefinedCompanyRolesByCompanyTypeName')
            ->with($companyTypeName)
            ->willReturn([$this->companyRoleTransferMock]);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyRoles);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'company-role',
                'company-role-delete',
                'company-role',
            );

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('delete')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getMessages')
            ->willReturn($responseErrorMessages);

        $this->responseMessageTransferMock->expects(static::atLeastOnce())
            ->method('getText')
            ->willReturn('error');

        $this->expectException(Exception::class);

        $this->synchronizer->sync();
    }

    /**
     * @return void
     */
    public function testSyncWithExceptionOnAdd(): void
    {
        $companies = new ArrayObject();
        $companies->append($this->companyTransferMock);
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);
        $companyTypeName = 'company-type';
        $responseErrorMessages = new ArrayObject();
        $responseErrorMessages->append($this->responseMessageTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCount')
            ->willReturn(2);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCollection')
            ->willReturn($this->companyCollectionTransferMock);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCompanySyncChunkSize')
            ->willReturn(2);

        $this->companyCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn($companies);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(1);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeByIdCompany')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyTypeName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getPredefinedCompanyRolesByCompanyTypeName')
            ->with($companyTypeName)
            ->willReturn([$this->companyRoleTransferMock]);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyRoles);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'company-role',
                'company-role-delete',
                'company-role-delete',
                'company-role-delete',
                'company-role-add',
            );

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('delete')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturnOnConsecutiveCalls(true, false);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getMessages')
            ->willReturn($responseErrorMessages);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->expectException(Exception::class);

        $this->synchronizer->sync();
    }

    /**
     * @return void
     */
    public function testSyncWithNoCompanyRolesIfDelete(): void
    {
        $companyTypeName = 'company-type';
        $companies = new ArrayObject();
        $companies->append($this->companyTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCollection')
            ->willReturn($this->companyCollectionTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCount')
            ->willReturn(1);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCompanySyncChunkSize')
            ->willReturn(2);

        $this->companyCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn($companies);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(1);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeByIdCompany')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyTypeName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getPredefinedCompanyRolesByCompanyTypeName')
            ->with($companyTypeName)
            ->willReturn([$this->companyRoleTransferMock]);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn(new ArrayObject());

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('test');

        $this->synchronizer->sync();
    }

    /**
     * @return void
     */
    public function testSyncWithNoCompanyRolesIfAdd(): void
    {
        $companyTypeName = 'company-type';
        $companies = new ArrayObject();
        $companies->append($this->companyTransferMock);

        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCollection')
            ->willReturn($this->companyCollectionTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCount')
            ->willReturn(1);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCompanySyncChunkSize')
            ->willReturn(2);

        $this->companyCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn($companies);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(1);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyTypeFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeByIdCompany')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyTypeName);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getPredefinedCompanyRolesByCompanyTypeName')
            ->with($companyTypeName)
            ->willReturn([$this->companyRoleTransferMock]);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyRoles);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'company-role',
                'company-role2',
                'company-role',
                'company-role',
            );

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('delete')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->synchronizer->sync();
    }

    /**
     * @return void
     */
    public function testSyncWithNoCompanies(): void
    {
        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCollection')
            ->willReturn($this->companyCollectionTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyCount')
            ->willReturn(1);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCompanySyncChunkSize')
            ->willReturn(2);

        $this->companyCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn(new ArrayObject());

        $this->synchronizer->sync();
    }
}
