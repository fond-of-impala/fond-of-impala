<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeBridge;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;

class AllowedProductQuantityCartConnectorDependencyProviderTest extends Unit
{
    protected AllowedProductQuantityCartConnectorDependencyProvider $allowedProductQuantityCartConnectorDependencyProvider;

    protected MockObject|Container $containerMock;

    protected MockObject|Locator $locatorMock;

    protected MockObject|BundleProxy $bundleProxyMock;

    protected MockObject|AllowedProductQuantityFacadeInterface $allowedProductQuantityFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'offsetSet', 'offsetGet', 'set', 'get'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityFacadeMock = $this->getMockBuilder(AllowedProductQuantityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityCartConnectorDependencyProvider = new AllowedProductQuantityCartConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testAddAllowedProductQuantityFacade(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('allowedProductQuantity')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturn($this->allowedProductQuantityFacadeMock);

        $this->assertEquals(
            $this->containerMock,
            $this->allowedProductQuantityCartConnectorDependencyProvider->provideBusinessLayerDependencies($this->containerMock),
        );

        $this->assertInstanceOf(
            AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeBridge::class,
            $this->containerMock[AllowedProductQuantityCartConnectorDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY],
        );
    }
}
