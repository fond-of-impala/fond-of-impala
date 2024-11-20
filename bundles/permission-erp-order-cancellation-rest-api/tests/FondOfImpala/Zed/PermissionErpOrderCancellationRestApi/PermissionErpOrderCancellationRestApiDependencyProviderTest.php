<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi;

use Codeception\Test\Unit;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\Permission\Persistence\Base\SpyPermissionQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;

class PermissionErpOrderCancellationRestApiDependencyProviderTest extends Unit
{
    protected MockObject|BundleProxy $bundleProxyMock;

    protected MockObject|Container $containerMock;

    protected MockObject|Locator $locatorMock;

    protected PermissionErpOrderCancellationRestApiDependencyProvider $dependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $containerMock = $this->getMockBuilder(Container::class);

        if (method_exists($containerMock, 'setMethodsExcept')) {
            $containerMock->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet']);
        } else {
            $containerMock->onlyMethods(['getLocator'])->enableOriginalClone();
        }

        $this->containerMock = $containerMock->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new PermissionErpOrderCancellationRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        $container = $this->dependencyProvider
            ->providePersistenceLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            SpyPermissionQuery::class,
            $container[PermissionErpOrderCancellationRestApiDependencyProvider::PROPEL_QUERY_PERMISSION],
        );

        self::assertInstanceOf(
            SpyCompanyQuery::class,
            $container[PermissionErpOrderCancellationRestApiDependencyProvider::PROPEL_QUERY_COMPANY],
        );

        self::assertInstanceOf(
            SpyCompanyRoleQuery::class,
            $container[PermissionErpOrderCancellationRestApiDependencyProvider::PROPEL_QUERY_COMPANY_ROLE],
        );

        self::assertInstanceOf(
            SpyCompanyUserQuery::class,
            $container[PermissionErpOrderCancellationRestApiDependencyProvider::PROPEL_QUERY_COMPANY_USER],
        );
    }
}
