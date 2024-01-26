<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientBridge;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Kernel\Locator;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\BundleProxy;

class CollaborativeCartsRestApiDependencyProviderTest extends Unit
{
    protected MockObject|BundleProxy $bundleProxyMock;

    protected MockObject|Container $containerMock;

    protected CollaborativeCartsRestApiDependencyProvider $collaborativeCartsRestApiDependencyProvider;

    protected MockObject|Locator $locatorMock;

    protected MockObject|ZedRequestClientInterface $zedRequestClientMock;

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

        $this->collaborativeCartsRestApiDependencyProvider = new CollaborativeCartsRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('zedRequest')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('client')
            ->willReturn($this->zedRequestClientMock);

        $container = $this->collaborativeCartsRestApiDependencyProvider->provideServiceLayerDependencies(
            $this->containerMock,
        );

        static::assertEquals($this->containerMock, $container);

        static::assertInstanceOf(
            CollaborativeCartsRestApiToZedRequestClientBridge::class,
            $container[CollaborativeCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST],
        );
    }
}
