<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssigner;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\PermissionReader;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReader;
use FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizer;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepository;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Spryker\Zed\Kernel\Container;

class CompanyTypeRoleBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface
     */
    protected $companyRoleAssignerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $configMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepository|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleBusinessFactory
     */
    protected $companyTypeRoleBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleAssignerMock = $this->getMockBuilder(CompanyRoleAssignerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyTypeRoleToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyTypeRoleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleBusinessFactory = new CompanyTypeRoleBusinessFactory();

        $this->companyTypeRoleBusinessFactory->setContainer($this->containerMock);
        $this->companyTypeRoleBusinessFactory->setConfig($this->configMock);
        $this->companyTypeRoleBusinessFactory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyRoleAssigner(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_TYPE],
                [CompanyTypeRoleDependencyProvider::FACADE_PERMISSION],
            )->willReturnOnConsecutiveCalls(true, true, true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_TYPE],
                [CompanyTypeRoleDependencyProvider::FACADE_PERMISSION],
            )->willReturnOnConsecutiveCalls(
                $this->companyRoleFacadeMock,
                $this->companyTypeFacadeMock,
                $this->permissionFacadeMock,
            );

        $companyRoleAssigner = $this->companyTypeRoleBusinessFactory->createCompanyRoleAssigner();

        static::assertInstanceOf(CompanyRoleAssigner::class, $companyRoleAssigner);
    }

    /**
     * @return void
     */
    public function testCreatePermissionSynchronizer(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [CompanyTypeRoleDependencyProvider::FACADE_PERMISSION],
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
            )->willReturnOnConsecutiveCalls(true, true, true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyTypeRoleDependencyProvider::FACADE_PERMISSION],
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
            )->willReturnOnConsecutiveCalls(
                $this->permissionFacadeMock,
                $this->companyRoleFacadeMock,
            );

        $permissionSynchronizer = $this->companyTypeRoleBusinessFactory->createPermissionSynchronizer();

        static::assertInstanceOf(PermissionSynchronizer::class, $permissionSynchronizer);
    }

    /**
     * @return void
     */
    public function testCreatePermissionReader(): void
    {
        $permissionReader = $this->companyTypeRoleBusinessFactory->createPermissionReader();

        static::assertInstanceOf(PermissionReader::class, $permissionReader);
    }

    /**
     * @return void
     */
    public function testCreateAssignableCompanyRoleReader(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_USER],
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyTypeRoleDependencyProvider::FACADE_PERMISSION],
            )->willReturnOnConsecutiveCalls(true, true, true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_USER],
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyTypeRoleDependencyProvider::FACADE_PERMISSION],
            )->willReturnOnConsecutiveCalls(
                $this->companyUserFacadeMock,
                $this->companyRoleFacadeMock,
                $this->permissionFacadeMock,
            );

        static::assertInstanceOf(
            AssignableCompanyRoleReader::class,
            $this->companyTypeRoleBusinessFactory->createAssignableCompanyRoleReader(),
        );
    }
}
