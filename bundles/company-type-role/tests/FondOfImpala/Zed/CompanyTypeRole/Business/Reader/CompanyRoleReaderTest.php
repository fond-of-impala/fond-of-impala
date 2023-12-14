<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Reader;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapperInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionSetTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class CompanyRoleReaderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\CompanyTypeRole\Business\Reader\PermissionReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionReaderMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapperInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionKeyMapperMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyRoleCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\PermissionSetTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionSetTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\PermissionSetTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invalidPermissionSetTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\PermissionCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\PermissionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReader
     */
    protected $companyRoleReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionReaderMock = $this->getMockBuilder(PermissionReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionKeyMapperMock = $this->getMockBuilder(PermissionKeyMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyTypeRoleRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionSetTransferMock = $this->getMockBuilder(PermissionSetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->invalidPermissionSetTransferMock = $this->getMockBuilder(PermissionSetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleReader = new CompanyRoleReader(
            $this->permissionReaderMock,
            $this->permissionKeyMapperMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyRolesByCompanyRoleIds(): void
    {
        $companyRoleIds = [1, 2, 3];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyRolesByCompanyRoleIds')
            ->with($companyRoleIds)
            ->willReturn($this->companyRoleCollectionTransferMock);

        static::assertEquals(
            $this->companyRoleCollectionTransferMock,
            $this->companyRoleReader->findCompanyRolesByCompanyRoleIds($companyRoleIds),
        );
    }

    /**
     * @return void
     */
    public function testFindSyncableCompanyRoles(): void
    {
        $companyType = 'foo';
        $companyRoleName = 'bar';
        $permissionKeys = ['key1'];
        $companyRoleIds = [1, 2, 4];

        $this->permissionReaderMock->expects(static::atLeastOnce())
            ->method('getPermissionSets')
            ->willReturn([$this->permissionSetTransferMock, $this->invalidPermissionSetTransferMock]);

        $this->invalidPermissionSetTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyType')
            ->willReturn(null);

        $this->invalidPermissionSetTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleName')
            ->willReturn($companyRoleName);

        $this->invalidPermissionSetTransferMock->expects(static::atLeastOnce())
            ->method('getEntries')
            ->willReturn(null);

        $this->permissionSetTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($companyType);

        $this->permissionSetTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleName')
            ->willReturn($companyRoleName);

        $this->permissionSetTransferMock->expects(static::atLeastOnce())
            ->method('getEntries')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getPermissions')
            ->willReturn(new ArrayObject([$this->permissionTransferMock]));

        $this->permissionKeyMapperMock->expects(static::atLeastOnce())
            ->method('fromPermissionCollection')
            ->with($this->permissionCollectionTransferMock)
            ->willReturn($permissionKeys);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findSyncableCompanyRoleIds')
            ->with($companyType, $companyRoleName, $permissionKeys)
            ->willReturn($companyRoleIds);

        $syncableCompanyRoles = $this->companyRoleReader->findSyncableCompanyRoles();

        static::assertCount(1, $syncableCompanyRoles);
        static::assertEquals($companyType, $syncableCompanyRoles[0]->getCompanyType());
        static::assertEquals($companyRoleName, $syncableCompanyRoles[0]->getName());
        static::assertEquals($companyRoleIds, $syncableCompanyRoles[0]->getIds());
        static::assertEquals($this->permissionCollectionTransferMock, $syncableCompanyRoles[0]->getPermissions());
    }
}
