<?php

namespace FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientBridge;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Kernel\Locator;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\BundleProxy;

class CompanyBusinessUnitsCartsRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Locator
     */
    protected $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiDependencyProvider
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

        $this->zedRequestClientMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsCartsRestApiDependencyProvider = new CompanyBusinessUnitsCartsRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(self::atLeastOnce())
            ->method('__call')
            ->with('zedRequest')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(self::atLeastOnce())
            ->method('__call')
            ->with('client')
            ->willReturn($this->zedRequestClientMock);

        $container = $this->companyBusinessUnitsCartsRestApiDependencyProvider->provideServiceLayerDependencies(
            $this->containerMock,
        );

        self::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            CompanyBusinessUnitsCartsRestApiToZedRequestClientBridge::class,
            $container[CompanyBusinessUnitsCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST],
        );
    }
}
