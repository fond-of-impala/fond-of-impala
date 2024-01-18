<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\CompanyBusinessUnitQuoteConnectorFacadeInterface;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeBridge;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridge;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;

class CompanyBusinessUnitsCartsRestApiDependencyProviderTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface
     */
    protected $companyBusinessUnitQuoteConnectorFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiDependencyProvider
     */
    protected $companyBusinessUnitsCartsRestApiDependencyProvider;

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

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteConnectorFacadeMock = $this->getMockBuilder(CompanyBusinessUnitQuoteConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsCartsRestApiDependencyProvider = new CompanyBusinessUnitsCartsRestApiDependencyProvider();
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
            ->withConsecutive(['companyBusinessUnit'], ['companyBusinessUnitQuoteConnector'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->companyBusinessUnitFacadeMock,
                $this->companyBusinessUnitQuoteConnectorFacadeMock,
            );

        $container = $this->companyBusinessUnitsCartsRestApiDependencyProvider->provideBusinessLayerDependencies(
            $this->containerMock,
        );

        $this->assertEquals($this->containerMock, $container);
        $this->assertInstanceOf(
            CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeBridge::class,
            $container[CompanyBusinessUnitsCartsRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT],
        );
        $this->assertInstanceOf(
            CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridge::class,
            $container[CompanyBusinessUnitsCartsRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT_QUOTE_CONNECTOR],
        );
    }
}
