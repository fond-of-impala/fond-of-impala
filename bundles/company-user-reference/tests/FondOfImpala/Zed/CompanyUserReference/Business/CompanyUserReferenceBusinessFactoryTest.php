<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyUserReference\Business\Generator\CompanyUserReferenceGenerator;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyBusinessUnitReader;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyReader;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyUserReader;
use FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig;
use FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceDependencyProvider;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepository;
use Spryker\Zed\Kernel\Container;

class CompanyUserReferenceBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepository
     */
    protected $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface
     */
    protected $sequenceNumberFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface
     */
    protected $storeFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceBusinessFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->configMock = $this->getMockBuilder(CompanyUserReferenceConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserReferenceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyUserReferenceToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyUserReferenceToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sequenceNumberFacadeMock = $this->getMockBuilder(CompanyUserReferenceToSequenceNumberFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(CompanyUserReferenceToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyUserReferenceBusinessFactory();
        $this->factory->setRepository($this->repositoryMock);
        $this->factory->setConfig($this->configMock);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserReferenceGenerator(): void
    {
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUserReferenceDependencyProvider::FACADE_SEQUENCE_NUMBER:
                        return $self->sequenceNumberFacadeMock;
                    case CompanyUserReferenceDependencyProvider::FACADE_STORE:
                        return $self->storeFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            CompanyUserReferenceGenerator::class,
            $this->factory->createCompanyUserReferenceGenerator(),
        );
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
            ->with(CompanyUserReferenceDependencyProvider::PLUGINS_COMPANY_USER_HYDRATE)
            ->willReturn([]);

        static::assertInstanceOf(CompanyUserReader::class, $this->factory->createCompanyUserReader());
    }

    /**
     * @return void
     */
    public function testCreateCompanyReader(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUserReferenceDependencyProvider::FACADE_COMPANY:
                        return $self->companyFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(CompanyReader::class, $this->factory->createCompanyReader());
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitReader(): void
    {
        $self = $this;

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyUserReferenceDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT:
                        return $self->companyBusinessUnitFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(CompanyBusinessUnitReader::class, $this->factory->createCompanyBusinessUnitReader());
    }
}
