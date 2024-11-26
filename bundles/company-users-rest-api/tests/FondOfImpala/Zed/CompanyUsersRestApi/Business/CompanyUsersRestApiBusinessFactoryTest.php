<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business;

use Codeception\Test\Unit;
use Exception;
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
            ->with(
                CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE,
            )->willReturn(
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
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER:
                        return $self->customerFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::SERVICE_UTIL_TEXT:
                        return $self->utilTextServiceMock;
                    case CompanyUsersRestApiDependencyProvider::FACADE_COMPANY:
                        return $self->companyFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT:
                        return $self->companyBusinessUnitFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER:
                        return $self->companyUserFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE:
                        return $self->companyUserReferenceFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION:
                        return $self->permissionFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_CREATE:
                        return [];
                    case CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_POST_CREATE:
                        return [];
                    case CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_DELETE_VALIDATION:
                        return [];
                    case CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_UPDATE_VALIDATION:
                        return [];
                }

                throw new Exception('Unexpected call');
            });

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
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_ROLE:
                        return $self->companyRoleFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER:
                        return $self->companyUserFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE:
                        return $self->companyUserReferenceFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION:
                        return $self->permissionFacadeMock;
                    case CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_CREATE:
                        return [];
                    case CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_POST_CREATE:
                        return [];
                    case CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_DELETE_VALIDATION:
                        return [];
                    case CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_UPDATE_VALIDATION:
                        return [];
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            CompanyUserUpdater::class,
            $this->companyUsersRestApiBusinessFactory->createCompanyUserUpdater(),
        );
    }
}
