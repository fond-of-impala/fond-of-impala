<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class CompanyRoleAssignerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    private $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\CompanyRoleTransfer>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $companyRoleTransferMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    protected $availablePermissionCollectionMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\PermissionTransfer[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected $availablePermissionMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    protected $companyRolePermissionCollectionMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\PermissionTransfer[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected $companyRolePermissionMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface
     */
    protected $companyRoleAssigner;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyTypeRoleToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMocks = [
            $this->getMockBuilder(CompanyRoleTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->availablePermissionCollectionMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->availablePermissionMocks = new ArrayObject(
            [
                $this->getMockBuilder(PermissionTransfer::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
            ],
        );

        $this->companyRolePermissionCollectionMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRolePermissionMocks = new ArrayObject(
            [
                $this->getMockBuilder(PermissionTransfer::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
                $this->getMockBuilder(PermissionTransfer::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
            ],
        );

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleAssigner = new CompanyRoleAssigner(
            $this->configMock,
            $this->companyRoleFacadeMock,
            $this->companyTypeFacadeMock,
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testAssignPredefinedCompanyRolesToNewCompanyWithInvalidCompanyTransfer(): void
    {
        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn(null);

        $companyResponseTransfer = $this->companyRoleAssigner
            ->assignPredefinedCompanyRolesToNewCompany($this->companyResponseTransferMock);

        $this->assertEquals($companyResponseTransfer, $this->companyResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testAssignPredefinedCompanyRolesToNewCompanyWithInvalidCompanyType(): void
    {
        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn(null);

        $companyResponseTransfer = $this->companyRoleAssigner
            ->assignPredefinedCompanyRolesToNewCompany($this->companyResponseTransferMock);

        $this->assertEquals($companyResponseTransfer, $this->companyResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testAssignPredefinedCompanyRolesToNewCompany(): void
    {
        $companyTypeName = 'retailer';
        $idCompany = 1;

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($companyTypeName);

        $this->configMock->expects($this->atLeastOnce())
            ->method('getPredefinedCompanyRolesByCompanyTypeName')
            ->willReturn($this->companyRoleTransferMocks);

        $this->permissionFacadeMock->expects($this->atLeastOnce())
            ->method('findMergedRegisteredNonInfrastructuralPermissions')
            ->willReturn($this->availablePermissionCollectionMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->companyRoleTransferMocks[0]->expects($this->atLeastOnce())
            ->method('setFkCompany')
            ->with($idCompany)
            ->willReturn($this->companyRoleTransferMocks[0]);

        $this->companyRoleTransferMocks[0]->expects($this->atLeastOnce())
            ->method('getPermissionCollection')
            ->willReturn($this->companyRolePermissionCollectionMock);

        $this->companyRolePermissionCollectionMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->companyRolePermissionMocks);

        $this->availablePermissionCollectionMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->availablePermissionMocks);

        $this->companyRolePermissionMocks[0]->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn('PermissionKey1');

        $this->companyRolePermissionMocks[1]->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn('PermissionKey2');

        $this->availablePermissionMocks[0]->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn('PermissionKey2');

        $this->companyRoleTransferMocks[0]->expects($this->atLeastOnce())
            ->method('setPermissionCollection')
            ->with($this->isInstanceOf(PermissionCollectionTransfer::class))
            ->willReturn($this->companyRoleTransferMocks);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->companyRoleTransferMocks[0])
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getMessages')
            ->willReturn(new ArrayObject());

        $companyResponseTransfer = $this->companyRoleAssigner
            ->assignPredefinedCompanyRolesToNewCompany($this->companyResponseTransferMock);

        $this->assertEquals($this->companyResponseTransferMock, $companyResponseTransfer);
    }

    /**
     * @return void
     */
    public function testAssignPredefinedCompanyRolesToNewCompanyWithoutCompanyTransferProperty(): void
    {
        $companyTypeName = 'retailer';
        $idCompany = 1;
        $fkCompanyType = 7;

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn(null);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($fkCompanyType);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeById')
            ->with($this->isInstanceOf(CompanyTypeTransfer::class))
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($companyTypeName);

        $this->configMock->expects($this->atLeastOnce())
            ->method('getPredefinedCompanyRolesByCompanyTypeName')
            ->willReturn($this->companyRoleTransferMocks);

        $this->permissionFacadeMock->expects($this->atLeastOnce())
            ->method('findMergedRegisteredNonInfrastructuralPermissions')
            ->willReturn($this->availablePermissionCollectionMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->companyRoleTransferMocks[0]->expects($this->atLeastOnce())
            ->method('setFkCompany')
            ->with($idCompany)
            ->willReturn($this->companyRoleTransferMocks[0]);

        $this->companyRoleTransferMocks[0]->expects($this->atLeastOnce())
            ->method('getPermissionCollection')
            ->willReturn($this->companyRolePermissionCollectionMock);

        $this->companyRolePermissionCollectionMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->companyRolePermissionMocks);

        $this->availablePermissionCollectionMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->availablePermissionMocks);

        $this->companyRolePermissionMocks[0]->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn('PermissionKey1');

        $this->companyRolePermissionMocks[1]->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn('PermissionKey2');

        $this->availablePermissionMocks[0]->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn('PermissionKey2');

        $this->companyRoleTransferMocks[0]->expects($this->atLeastOnce())
            ->method('setPermissionCollection')
            ->with($this->isInstanceOf(PermissionCollectionTransfer::class))
            ->willReturn($this->companyRoleTransferMocks);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->companyRoleTransferMocks[0])
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getMessages')
            ->willReturn(new ArrayObject());

        $companyResponseTransfer = $this->companyRoleAssigner
            ->assignPredefinedCompanyRolesToNewCompany($this->companyResponseTransferMock);

        $this->assertEquals($this->companyResponseTransferMock, $companyResponseTransfer);
    }
}
