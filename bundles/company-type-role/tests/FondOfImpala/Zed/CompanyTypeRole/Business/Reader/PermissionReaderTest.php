<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\PermissionCollectionTransfer;

class PermissionReaderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionIntersectionMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var (\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionFacadeMock;

    /**
     * @var (\Generated\Shared\Transfer\PermissionCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Reader\PermissionReader
     */
    protected $permissionReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionIntersectionMock = $this->getMockBuilder(PermissionIntersectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyTypeRoleToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionReader = new PermissionReader(
            $this->permissionIntersectionMock,
            $this->configMock,
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetPermissions(): void
    {
        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('findAll')
            ->willReturn($this->permissionCollectionTransferMock);

        static::assertEquals(
            $this->permissionCollectionTransferMock,
            $this->permissionReader->getPermissions(),
        );
    }

    /**
     * @return void
     */
    public function testGetPermissionSets(): void
    {
        $companyType = 'foo';
        $companyRoleName = 'bar';

        $groupedPermissionKeys = [
            $companyType => [
                $companyRoleName => [
                    'key1',
                    'key3',
                ],
            ],
        ];

        $this->configMock->expects(static::atLeastOnce())
            ->method('getGroupedPermissionKeys')
            ->willReturn($groupedPermissionKeys);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('findAll')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionIntersectionMock->expects(static::atLeastOnce())
            ->method('intersect')
            ->with($this->permissionCollectionTransferMock, $groupedPermissionKeys[$companyType][$companyRoleName])
            ->willReturn($this->permissionCollectionTransferMock);

        $permissionSets = $this->permissionReader->getPermissionSets();

        static::assertCount(1, $permissionSets);
        static::assertEquals($companyType, $permissionSets[0]->getCompanyType());
        static::assertEquals($companyRoleName, $permissionSets[0]->getCompanyRoleName());
        static::assertEquals($this->permissionCollectionTransferMock, $permissionSets[0]->getEntries());
    }
}
