<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class CompanyTypeRoleWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer
     */
    protected $companyRoleCriteriaFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    protected $companyTypeResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeRoleWriterInterface
     */
    protected $companyTypeRoleWriter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface
     */
    protected $companyTypeRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionTransfer
     */
    protected $permissionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(CompanyTypeConverterConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCriteriaFilterTransferMock = $this->getMockBuilder(CompanyRoleCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeResponseTransferMock = $this->getMockBuilder(CompanyTypeResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyTypeRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyTypeConverterToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleWriter = new CompanyTypeRoleWriter(
            $this->companyRoleFacadeMock,
            $this->companyTypeFacadeMock,
            $this->companyTypeRoleFacadeMock,
            $this->permissionFacadeMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyRoles(): void
    {
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);
        $permissions = new ArrayObject();
        $permissions->append($this->permissionTransferMock);
        $defaultRoleMapping = ['role' => 'default_role'];
        $permissionKeys = ['permission_key_1'];

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(1);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyRoles);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('current_role');

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn(1);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->configMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeDefaultRoleMapping')
            ->willReturn($defaultRoleMapping);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('company_type');

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('addRole')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyTypeRoleFacadeMock->expects($this->atLeastOnce())
            ->method('getPermissionKeysByCompanyTypeAndCompanyRole')
            ->willReturn($permissionKeys);

        $this->permissionFacadeMock->expects($this->atLeastOnce())
            ->method('findMergedRegisteredNonInfrastructuralPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($permissions);

        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn('permission_key_1');

        /*$this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('addPermission')
            ->willReturn($this->permissionCollectionTransferMock);*/

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('setPermissionCollection')
            ->willReturn($this->companyRoleTransferMock);

        $this->assertInstanceOf(
            CompanyRoleCollectionTransfer::class,
            $this->companyTypeRoleWriter->updateCompanyRoles($this->companyTransferMock),
        );
    }
}
