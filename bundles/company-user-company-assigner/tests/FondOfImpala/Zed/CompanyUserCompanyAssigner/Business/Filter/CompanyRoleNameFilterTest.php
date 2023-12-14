<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRoleNameFilterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilter
     */
    protected $companyRoleNameFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleNameFilter = new CompanyRoleNameFilter(
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testFilterFromCompanyUser(): void
    {
        $idCompanyRole = 1;
        $companyRoleName = 'foo';

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn(new ArrayObject([$this->companyRoleTransferMock]));

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn(null);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn($idCompanyRole);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyRoleNameByIdCompanyRole')
            ->with($idCompanyRole)
            ->willReturn($companyRoleName);

        static::assertEquals(
            $companyRoleName,
            $this->companyRoleNameFilter->filterFromCompanyUser($this->companyUserTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromCompanyUserWithEmptyRoles(): void
    {
        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn(new ArrayObject());

        $this->repositoryMock->expects(static::never())
            ->method('findCompanyRoleNameByIdCompanyRole');

        static::assertEquals(
            null,
            $this->companyRoleNameFilter->filterFromCompanyUser($this->companyUserTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromCompanyUserWithoutAdditionalQuery(): void
    {
        $idCompanyRole = 1;
        $companyRoleName = 'foo';

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn(new ArrayObject([$this->companyRoleTransferMock]));

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyRoleName);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn($idCompanyRole);

        $this->repositoryMock->expects(static::never())
            ->method('findCompanyRoleNameByIdCompanyRole');

        static::assertEquals(
            $companyRoleName,
            $this->companyRoleNameFilter->filterFromCompanyUser($this->companyUserTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFilterFromCompanyUserWithInvalidCompanyRoleData(): void
    {
        $idCompanyRole = null;

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn(new ArrayObject([$this->companyRoleTransferMock]));

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn(null);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn($idCompanyRole);

        $this->repositoryMock->expects(static::never())
            ->method('findCompanyRoleNameByIdCompanyRole');

        static::assertEquals(
            null,
            $this->companyRoleNameFilter->filterFromCompanyUser($this->companyUserTransferMock),
        );
    }
}
