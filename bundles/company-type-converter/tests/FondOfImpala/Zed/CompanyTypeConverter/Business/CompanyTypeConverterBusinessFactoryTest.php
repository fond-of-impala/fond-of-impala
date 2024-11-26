<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyReaderInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverter;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeRoleWriterInterface;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterDependencyProvider;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface;
use Spryker\Zed\Kernel\Container;

class CompanyTypeConverterBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterBusinessFactory
     */
    protected $companyTypeConverterBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface
     */
    protected $companyTypeConverterToCompanyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface
     */
    protected $companyTypeConverterToCompanyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface
     */
    protected $companyTypeConverterToCompanyTypeRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface
     */
    protected $companyTypeConverterToCompanyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeInterface
     */
    protected $companyTypeConverterToCompanyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface
     */
    protected $companyTypeConverterToPermissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeRoleWriterInterface
     */
    protected $companyTypeRolewriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(CompanyTypeConverterConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToCompanyTypeFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToCompanyRoleFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToCompanyUserFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToCompanyFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToCompanyTypeRoleFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyTypeRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToPermissionFacadeMock = $this->getMockBuilder(CompanyTypeConverterToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRolewriter = $this->getMockBuilder(CompanyTypeRoleWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterBusinessFactory = new CompanyTypeConverterBusinessFactory();
        $this->companyTypeConverterBusinessFactory->setContainer($this->containerMock);
        $this->companyTypeConverterBusinessFactory->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyTypeConverter(): void
    {
        $self = $this;

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyTypeConverterDependencyProvider::FACADE_COMPANY_TYPE:
                        return $self->companyTypeConverterToCompanyTypeFacadeMock;
                    case CompanyTypeConverterDependencyProvider::FACADE_COMPANY_ROLE:
                        return $self->companyTypeConverterToCompanyRoleFacadeMock;
                    case CompanyTypeConverterDependencyProvider::FACADE_COMPANY_USER:
                        return $self->companyTypeConverterToCompanyUserFacadeMock;
                    case CompanyTypeConverterDependencyProvider::FACADE_COMPANY_TYPE_ROLE:
                        return $self->companyTypeConverterToCompanyTypeRoleFacadeMock;
                    case CompanyTypeConverterDependencyProvider::FACADE_PERMISSION:
                        return $self->companyTypeConverterToPermissionFacadeMock;
                    case CompanyTypeConverterDependencyProvider::COMPANY_TYPE_CONVERTER_PRE_SAVE_PLUGINS:
                        return [];
                    case CompanyTypeConverterDependencyProvider::COMPANY_TYPE_CONVERTER_POST_SAVE_PLUGINS:
                        return [];
                }

                throw new Exception('Unexpected call');
            });

        $this->assertInstanceOf(
            CompanyTypeConverter::class,
            $this->companyTypeConverterBusinessFactory->createCompanyTypeConverter(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyReader(): void
    {
        $self = $this;

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CompanyTypeConverterDependencyProvider::FACADE_COMPANY:
                        return $self->companyTypeConverterToCompanyFacadeMock;
                    case CompanyTypeConverterDependencyProvider::FACADE_COMPANY_TYPE:
                        return $self->companyTypeConverterToCompanyTypeFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        $this->assertInstanceOf(
            CompanyReaderInterface::class,
            $this->companyTypeConverterBusinessFactory->createCompanyReader(),
        );
    }
}
