<?php

namespace FondOfImpala\Zed\CompanyTypeConverter;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeBridge;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeBridge;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeBridge;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeBridge;
use FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyTypeConverterDependencyProviderTest extends Unit
{
    /**
     * @var \Spryker\Zed\Kernel\Locator|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $locatorMock;

    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \Spryker\Shared\Kernel\BundleProxy|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface
     */
    protected $companyTypeRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterDependencyProvider
     */
    protected $companyTypeConverterDependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterDependencyProvider = new CompanyTypeConverterDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('__call')
            ->withConsecutive(
                ['permission'],
                ['companyTypeRole'],
                ['companyRole'],
                ['companyType'],
                ['companyUser'],
            )
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->permissionFacadeMock,
                $this->companyTypeRoleFacadeMock,
                $this->companyRoleFacadeMock,
                $this->companyTypeFacadeMock,
                $this->companyUserFacadeMock,
            );

        $this->assertEquals(
            $this->containerMock,
            $this->companyTypeConverterDependencyProvider->provideBusinessLayerDependencies($this->containerMock),
        );

        $this->assertInstanceOf(
            CompanyTypeConverterToPermissionFacadeBridge::class,
            $this->containerMock[CompanyTypeConverterDependencyProvider::FACADE_PERMISSION],
        );

        $this->assertInstanceOf(
            CompanyTypeConverterToCompanyTypeRoleFacadeBridge::class,
            $this->containerMock[CompanyTypeConverterDependencyProvider::FACADE_COMPANY_TYPE_ROLE],
        );

        $this->assertInstanceOf(
            CompanyTypeConverterToCompanyRoleFacadeBridge::class,
            $this->containerMock[CompanyTypeConverterDependencyProvider::FACADE_COMPANY_ROLE],
        );

        $this->assertInstanceOf(
            CompanyTypeConverterToCompanyTypeFacadeBridge::class,
            $this->containerMock[CompanyTypeConverterDependencyProvider::FACADE_COMPANY_TYPE],
        );

        $this->isTrue(
            is_array(
                $this->containerMock[CompanyTypeConverterDependencyProvider::COMPANY_TYPE_CONVERTER_POST_SAVE_PLUGINS],
            ),
        );

        $this->isTrue(
            is_array(
                $this->containerMock[CompanyTypeConverterDependencyProvider::COMPANY_TYPE_CONVERTER_PRE_SAVE_PLUGINS],
            ),
        );
    }
}
