<?php

namespace FondOfImpala\Zed\CompanyTypeRole;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeBridge;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeBridge;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeBridge;
use FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyTypeRoleDependencyProviderTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider
     */
    protected $companyTypeRoleDependencyProvider;

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

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleDependencyProvider = new CompanyTypeRoleDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->exactly(3))
            ->method('__call')
            ->withConsecutive(['companyRole'], ['companyType'], ['permission'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->exactly(3))
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->companyRoleFacadeMock,
                $this->companyTypeFacadeMock,
                $this->permissionFacadeMock,
            );

        $this->assertEquals(
            $this->containerMock,
            $this->companyTypeRoleDependencyProvider->provideBusinessLayerDependencies($this->containerMock),
        );

        $this->assertInstanceOf(
            CompanyTypeRoleToCompanyRoleFacadeBridge::class,
            $this->containerMock[CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
        );

        $this->assertInstanceOf(
            CompanyTypeRoleToCompanyTypeFacadeBridge::class,
            $this->containerMock[CompanyTypeRoleDependencyProvider::FACADE_COMPANY_TYPE],
        );

        $this->assertInstanceOf(
            CompanyTypeRoleToPermissionFacadeBridge::class,
            $this->containerMock[CompanyTypeRoleDependencyProvider::FACADE_PERMISSION],
        );
    }
}
