<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeBridge;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeBridge;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorFacadeInterface;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyBusinessUnitQuoteConnectorDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Locator
     */
    protected $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorFacadeInterface
     */
    protected $companyUserReferenceQuoteConnectorFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\CompanyBusinessUnitQuoteConnectorDependencyProvider
     */
    protected $companyBusinessUnitQuoteConnectorDependencyProvider;

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

        $this->companyUserReferenceQuoteConnectorFacadeMock = $this->getMockBuilder(CompanyUserReferenceQuoteConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteConnectorDependencyProvider = new CompanyBusinessUnitQuoteConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(self::atLeastOnce())
            ->method('__call')
            ->withConsecutive(['permission'], ['companyUserReferenceQuoteConnector'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(self::atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->permissionFacadeMock,
                $this->companyUserReferenceQuoteConnectorFacadeMock,
            );

        $container = $this->companyBusinessUnitQuoteConnectorDependencyProvider->provideBusinessLayerDependencies(
            $this->containerMock,
        );

        self::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            CompanyBusinessUnitQuoteConnectorToPermissionFacadeBridge::class,
            $container[CompanyBusinessUnitQuoteConnectorDependencyProvider::FACADE_PERMISSION],
        );

        self::assertInstanceOf(
            CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeBridge::class,
            $container[CompanyBusinessUnitQuoteConnectorDependencyProvider::FACADE_COMPANY_USER_REFERENCE_QUOTE_CONNECTOR],
        );
    }
}
