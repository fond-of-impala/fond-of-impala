<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReader;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Updater\CompanyUserUpdater;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepository;
use Spryker\Zed\Kernel\Container;

class CompanyUsersRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiBusinessFactory
     */
    protected $companyUsersRestApiBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepository
     */
    protected $companyUsersRestApiRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $companyUsersRestApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor
     */
    protected $companyUserPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $utilTextServiceMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUsersRestApiRepositoryMock = $this->getMockBuilder(CompanyUsersRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiConfigMock = $this->getMockBuilder(CompanyUsersRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserPluginExecutorMock = $this->getMockBuilder(CompanyUserPluginExecutor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->utilTextServiceMock = $this->getMockBuilder(CompanyUsersRestApiToUtilTextServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiBusinessFactory = new CompanyUsersRestApiBusinessFactory();
        $this->companyUsersRestApiBusinessFactory->setRepository($this->companyUsersRestApiRepositoryMock);
        $this->companyUsersRestApiBusinessFactory->setConfig($this->companyUsersRestApiConfigMock);
        $this->companyUsersRestApiBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserReader(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
            )->willReturnOnConsecutiveCalls(
                $this->companyUserReferenceFacadeMock,
            );

        static::assertInstanceOf(
            CompanyUserReader::class,
            $this->companyUsersRestApiBusinessFactory->createCompanyUserReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserWriter(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER],
                [CompanyUsersRestApiDependencyProvider::SERVICE_UTIL_TEXT],
                [CompanyUsersRestApiDependencyProvider::SERVICE_UTIL_TEXT],
                [CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION],
                [CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_CREATE],
                [CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_POST_CREATE],
            )->willReturnOnConsecutiveCalls(
                $this->customerFacadeMock,
                $this->utilTextServiceMock,
                $this->utilTextServiceMock,
                $this->customerFacadeMock,
                $this->companyFacadeMock,
                $this->companyBusinessUnitFacadeMock,
                $this->companyUserFacadeMock,
                $this->companyUserReferenceFacadeMock,
                $this->permissionFacadeMock,
                [],
                [],
            );

        static::assertInstanceOf(
            CompanyUserWriter::class,
            $this->companyUsersRestApiBusinessFactory->createCompanyUserWriter(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserUpdater(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER],
                [CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION],
            )->willReturnOnConsecutiveCalls(
                $this->companyUserReferenceFacadeMock,
                $this->companyRoleFacadeMock,
                $this->companyUserFacadeMock,
                $this->permissionFacadeMock,
            );

        static::assertInstanceOf(
            CompanyUserUpdater::class,
            $this->companyUsersRestApiBusinessFactory->createCompanyUserUpdater(),
        );
    }
}
