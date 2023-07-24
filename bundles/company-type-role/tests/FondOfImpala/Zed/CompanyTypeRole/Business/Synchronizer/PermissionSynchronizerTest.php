<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Business\Builder\CompanyRoleCriteriaFilterBuilderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionSynchronizerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeNameFilterMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionIntersectionMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Builder\CompanyRoleCriteriaFilterBuilderInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCriteriaFilterBuilderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \Generated\Shared\Transfer\PermissionCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject>|array<\Generated\Shared\Transfer\PermissionTransfer>
     */
    protected $permissionTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\CompanyRoleCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $companyRoleCollectionTransferMocks;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject>|array<\Generated\Shared\Transfer\CompanyRoleTransfer>
     */
    protected $companyRoleTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\PermissionCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $intersectedPermissionCollectionTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $companyRoleCriteriaFilterTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\PaginationTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $paginationTransferMock;

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

        $this->companyTypeNameFilterMock = $this->getMockBuilder(CompanyTypeNameFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionIntersectionMock = $this->getMockBuilder(PermissionIntersectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCriteriaFilterBuilderMock = $this->getMockBuilder(CompanyRoleCriteriaFilterBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyTypeRoleToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMocks = [
            $this->getMockBuilder(PermissionTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->companyRoleCollectionTransferMocks = [
            $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->companyRoleTransferMocks = [
            $this->getMockBuilder(CompanyRoleTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(CompanyRoleTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(CompanyRoleTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->intersectedPermissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCriteriaFilterTransferMocks = [
            $this->getMockBuilder(CompanyRoleCriteriaFilterTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(CompanyRoleCriteriaFilterTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->paginationTransferMock = $this->getMockBuilder(PaginationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionSynchronizer = new PermissionSynchronizer(
            $this->companyTypeNameFilterMock,
            $this->permissionIntersectionMock,
            $this->companyRoleCriteriaFilterBuilderMock,
            $this->companyRoleFacadeMock,
            $this->permissionFacadeMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testSync(): void
    {
        $companyTypeNames = ['TypeA', 'TypeB'];
        $companyRoleNames = ['RoleA', 'RoleB'];
        $permissionKeys = ['PermissionA'];

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('findAll')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getPermissions')
            ->willReturn(new ArrayObject($this->permissionTransferMocks));

        $this->companyRoleCriteriaFilterBuilderMock->expects(static::atLeastOnce())
            ->method('buildByPageAndMaxPerPage')
            ->withConsecutive([1, 1], [1, PermissionSynchronizer::PAGINATION_MAX_PER_PAGE])
            ->willReturnOnConsecutiveCalls(
                $this->companyRoleCriteriaFilterTransferMocks[0],
                $this->companyRoleCriteriaFilterTransferMocks[1],
            );

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->withConsecutive(
                [$this->companyRoleCriteriaFilterTransferMocks[0]],
                [$this->companyRoleCriteriaFilterTransferMocks[1]],
            )->willReturnOnConsecutiveCalls(
                $this->companyRoleCollectionTransferMocks[0],
                $this->companyRoleCollectionTransferMocks[1],
            );

        $this->companyRoleCollectionTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getPagination')
            ->willReturn($this->paginationTransferMock);

        $this->paginationTransferMock->expects(static::atLeastOnce())
            ->method('getNbResults')
            ->willReturn(count($this->companyRoleTransferMocks));

        $this->companyRoleCollectionTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn(new ArrayObject($this->companyRoleTransferMocks));

        $this->companyRoleTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyRoleNames[0]);

        $this->companyRoleTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyRoleNames[1]);

        $this->companyRoleTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn(null);

        $this->companyTypeNameFilterMock->expects(static::atLeastOnce())
            ->method('filterFromCompanyRole')
            ->withConsecutive(
                [$this->companyRoleTransferMocks[0]],
                [$this->companyRoleTransferMocks[1]],
                [$this->companyRoleTransferMocks[2]],
            )->willReturnOnConsecutiveCalls(
                $companyTypeNames[0],
                $companyTypeNames[1],
                null,
            );

        $this->configMock->expects(static::atLeastOnce())
            ->method('getPermissionKeys')
            ->withConsecutive(
                [$companyTypeNames[0], $companyRoleNames[0]],
                [$companyTypeNames[1], $companyRoleNames[1]],
            )->willReturnOnConsecutiveCalls([], $permissionKeys);

        $this->permissionIntersectionMock->expects(static::atLeastOnce())
            ->method('intersect')
            ->with($this->permissionCollectionTransferMock, $permissionKeys)
            ->willReturn($this->intersectedPermissionCollectionTransferMock);

        $this->companyRoleTransferMocks[0]->expects(static::never())
            ->method('setPermissionCollection');

        $this->companyRoleTransferMocks[1]->expects(static::atLeastOnce())
            ->method('setPermissionCollection')
            ->with($this->intersectedPermissionCollectionTransferMock)
            ->willReturn($this->companyRoleTransferMocks);

        $this->companyRoleTransferMocks[2]->expects(static::never())
            ->method('setPermissionCollection');

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->companyRoleTransferMocks[1]);

        $this->permissionSynchronizer->sync();
    }
}
