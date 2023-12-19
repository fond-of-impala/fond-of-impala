<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRoleManagerTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReaderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject|
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleTransfer|\PHPUnit\Framework\MockObject\MockObject|
     */
    protected $companyRoleTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager\CompanyRoleManagerInterface
     */
    protected $companyRoleManager;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyUserCompanyAssignerConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleManager = new CompanyRoleManager(
            $this->companyUserReaderMock,
            $this->companyRoleFacadeMock,
            $this->companyTypeFacadeMock,
            $this->configMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyRolesOfNonManufacturerUsers(): void
    {
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);

        $companyUsers = [
            '1' => [
                'id_company_user' => 1,
                'id_company' => 1,
                'company_roles' => [],
            ],
        ];

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyRoles);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleById')
            ->with($this->companyRoleTransferMock)
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn([]);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                '',
                'company-role',
                'company-role',
                'company-role',
                'company-role',
                'company-role',
            );

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('findWithInconsistentCompanyRolesByManufacturerUser')
            ->willReturn($companyUsers);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollectionByCompanyId')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn(1);

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('saveCompanyUser');

        $this->companyRoleManager->updateCompanyRolesOfNonManufacturerUsers($this->companyUserTransferMock);
    }
}
