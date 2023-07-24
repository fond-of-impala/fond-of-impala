<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyTypeRoleToPermissionFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeBridge
     */
    protected $companyTypeRoleToPermissionFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleToPermissionFacadeBridge = new CompanyTypeRoleToPermissionFacadeBridge(
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('findMergedRegisteredNonInfrastructuralPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $permissionCollectionTransfer = $this->companyTypeRoleToPermissionFacadeBridge
            ->findMergedRegisteredNonInfrastructuralPermissions();

        static::assertEquals($this->permissionCollectionTransferMock, $permissionCollectionTransfer);
    }

    /**
     * @return void
     */
    public function testFindAll(): void
    {
        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('findAll')
            ->willReturn($this->permissionCollectionTransferMock);

        $permissionCollectionTransfer = $this->companyTypeRoleToPermissionFacadeBridge
            ->findAll();

        static::assertEquals($this->permissionCollectionTransferMock, $permissionCollectionTransfer);
    }

    /**
     * @return void
     */
    public function testCan(): void
    {
        $permissionKey = 'foo';
        $identifier = 'bar';

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with($permissionKey, $identifier, null)
            ->willReturn(true);

        static::assertTrue($this->companyTypeRoleToPermissionFacadeBridge->can($permissionKey, $identifier));
    }
}
