<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\SyncableCompanyRoleTransfer;

class PermissionSynchronizerTest extends Unit
{
 /**
  * @var (\FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
  */
    protected $companyRoleReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleFacadeMock;

    /**
     * @var (\Generated\Shared\Transfer\SyncableCompanyRoleTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $syncableCompanyRoleTransfer;

    /**
     * @var (\Generated\Shared\Transfer\SyncableCompanyRoleTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invalidSyncableCompanyRoleTransfer;

    /**
     * @var (\Generated\Shared\Transfer\CompanyRoleCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\PermissionCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyRoleTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizer
     */
    protected $permissionSynchronizer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleReaderMock = $this->getMockBuilder(CompanyRoleReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->syncableCompanyRoleTransfer = $this->getMockBuilder(SyncableCompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->invalidSyncableCompanyRoleTransfer = $this->getMockBuilder(SyncableCompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock =
            $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->permissionSynchronizer = new PermissionSynchronizer(
            $this->companyRoleReaderMock,
            $this->companyRoleFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testSync(): void
    {
        $companyRoleIds = [1];

        $this->companyRoleReaderMock->expects(static::atLeastOnce())
            ->method('findSyncableCompanyRoles')
            ->willReturn([
                $this->invalidSyncableCompanyRoleTransfer,
                $this->syncableCompanyRoleTransfer,
            ]);

        $this->invalidSyncableCompanyRoleTransfer->expects(static::atLeastOnce())
            ->method('getIds')
            ->willReturn([]);

        $this->invalidSyncableCompanyRoleTransfer->expects(static::never())
            ->method('getPermissions');

        $this->syncableCompanyRoleTransfer->expects(static::atLeastOnce())
            ->method('getIds')
            ->willReturn($companyRoleIds);

        $this->syncableCompanyRoleTransfer->expects(static::atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->companyRoleReaderMock->expects(static::atLeastOnce())
            ->method('findCompanyRolesByCompanyRoleIds')
            ->with($companyRoleIds)
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn(new ArrayObject([$this->companyRoleTransferMock]));

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('setPermissionCollection')
            ->with($this->permissionCollectionTransferMock)
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->companyRoleTransferMock);

        $this->permissionSynchronizer->sync();
    }
}
