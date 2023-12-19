<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleDeleter;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReaderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizerInterface;
use Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyTypeRoleFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacade
     */
    protected $companyTypeRoleFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleBusinessFactory
     */
    protected $companyTypeRoleBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface
     */
    protected $companyRoleAssignerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizerInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $permissionSynchronizerMock;

    /**
     * @var \Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $assignableCompanyRoleCriteriaFilterTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReaderInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $assignableCompanyRoleReaderMock;

    protected CompanyRoleDeleter|MockObject $companyRoleDeleterMock;

    protected CompanyRoleTransfer|MockObject $companyRoleTransferMock;

    protected CompanyRoleResponseTransfer|MockObject $companyRoleResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeRoleBusinessFactoryMock = $this->getMockBuilder(CompanyTypeRoleBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleAssignerMock = $this->getMockBuilder(CompanyRoleAssignerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionSynchronizerMock = $this->getMockBuilder(PermissionSynchronizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assignableCompanyRoleCriteriaFilterTransferMock = $this->getMockBuilder(AssignableCompanyRoleCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assignableCompanyRoleReaderMock = $this->getMockBuilder(AssignableCompanyRoleReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleDeleterMock = $this->getMockBuilder(CompanyRoleDeleter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleFacade = new CompanyTypeRoleFacade();

        $this->companyTypeRoleFacade->setFactory($this->companyTypeRoleBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testAssignPredefinedCompanyRolesToNewCompany(): void
    {
        $this->companyTypeRoleBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createCompanyRoleAssigner')
            ->willReturn($this->companyRoleAssignerMock);

        $this->companyRoleAssignerMock->expects(static::atLeastOnce())
            ->method('assignPredefinedCompanyRolesToNewCompany')
            ->with($this->companyResponseTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $companyResponseTransfer = $this->companyTypeRoleFacade
            ->assignPredefinedCompanyRolesToNewCompany($this->companyResponseTransferMock);

        static::assertEquals($companyResponseTransfer, $this->companyResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testSyncPermissions(): void
    {
        $this->companyTypeRoleBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createPermissionSynchronizer')
            ->willReturn($this->permissionSynchronizerMock);

        $this->permissionSynchronizerMock->expects(static::atLeastOnce())
            ->method('sync');

        $this->companyTypeRoleFacade->syncPermissions();
    }

    /**
     * @return void
     */
    public function testGetAssignableCompanyRoles(): void
    {
        $this->companyTypeRoleBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createAssignableCompanyRoleReader')
            ->willReturn($this->assignableCompanyRoleReaderMock);

        $this->assignableCompanyRoleReaderMock->expects(static::atLeastOnce())
            ->method('getByAssignableCompanyRoleCriteriaFilter')
            ->with($this->assignableCompanyRoleCriteriaFilterTransferMock)
            ->willReturn($this->companyRoleCollectionTransferMock);

        static::assertEquals(
            $this->companyRoleCollectionTransferMock,
            $this->companyTypeRoleFacade->getAssignableCompanyRoles(
                $this->assignableCompanyRoleCriteriaFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyRoleAndCompanyUserByCompanyRole(): void
    {
        $this->companyTypeRoleBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createCompanyRoleDeleter')
            ->willReturn($this->companyRoleDeleterMock);

        $this->companyRoleDeleterMock->expects(static::atLeastOnce())
            ->method('deleteCompanyRoleAndCompanyUserByCompanyRole')
            ->with($this->companyRoleTransferMock)
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyTypeRoleFacade->deleteCompanyRoleAndCompanyUserByCompanyRole(
            $this->companyRoleTransferMock,
        );
    }
}
