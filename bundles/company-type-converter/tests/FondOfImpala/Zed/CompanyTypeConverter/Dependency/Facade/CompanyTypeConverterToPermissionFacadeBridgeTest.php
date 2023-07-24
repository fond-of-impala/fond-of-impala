<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyTypeConverterToPermissionFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionTransfer
     */
    protected $permissionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeBridge
     */
    protected $companyTypeConverterToPermissionFacadeBridge;

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

        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToPermissionFacadeBridge = new CompanyTypeConverterToPermissionFacadeBridge(
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindMergedRegisteredNonInfrastructuralPermissions(): void
    {
        $this->permissionFacadeMock->expects($this->atLeastOnce())
            ->method('findMergedRegisteredNonInfrastructuralPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $permissionCollectionTransfer = $this->companyTypeConverterToPermissionFacadeBridge
            ->findMergedRegisteredNonInfrastructuralPermissions();

        $this->assertEquals($this->permissionCollectionTransferMock, $permissionCollectionTransfer);
        $this->assertInstanceOf(
            PermissionCollectionTransfer::class,
            $this->permissionCollectionTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKey(): void
    {
        $permissionKey = 'permissionKey';

        $this->permissionFacadeMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->with($permissionKey)
            ->willReturn($this->permissionTransferMock);

        $permissionTransfer = $this->companyTypeConverterToPermissionFacadeBridge
            ->findPermissionByKey($permissionKey);

        $this->assertEquals($this->permissionTransferMock, $permissionTransfer);
        $this->assertInstanceOf(
            PermissionTransfer::class,
            $permissionTransfer,
        );
    }
}
