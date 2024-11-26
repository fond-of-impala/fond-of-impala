<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssigner;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager\CompanyRoleManager;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyTypeReader;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepository;
use Spryker\Zed\Kernel\Container;

class CompanyUserCompanyAssignerBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepository
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerBusinessFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyUserCompanyAssignerConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyUserCompanyAssignerBusinessFactory();
        $this->factory->setRepository($this->repositoryMock);
        $this->factory->setConfig($this->configMock);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUser(): void
    {
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_USER:
                        return $self->companyUserFacadeMock;
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY:
                        return $self->companyFacadeMock;
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_TYPE:
                        return $self->companyTypeFacadeMock;
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_ROLE:
                        return $self->companyRoleFacadeMock;
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT:
                        return $self->companyBusinessUnitFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            CompanyUser::class,
            $this->factory->createCompanyUser(),
        );
    }

    /**
     * @return void
     */
    public function testCreateManufacturerUserAssigner(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_USER:
                        return $self->companyUserFacadeMock;
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_TYPE:
                        return $self->companyTypeFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            ManufacturerUserAssigner::class,
            $this->factory->createManufacturerUserAssigner(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyRoleManager(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_TYPE:
                        return $self->companyTypeFacadeMock;
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_ROLE:
                        return $self->companyRoleFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(CompanyRoleManager::class, $this->factory->createCompanyRoleManager());
    }

    /**
     * @return void
     */
    public function testCreateCompanyTypeReader(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_TYPE:
                        return $self->companyTypeFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            CompanyTypeReader::class,
            $this->factory->createCompanyTypeReader(),
        );
    }
}
