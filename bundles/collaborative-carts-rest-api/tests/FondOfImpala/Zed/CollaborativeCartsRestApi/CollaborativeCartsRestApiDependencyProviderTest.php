<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartFacadeInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeBridge;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeBridge;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Quote\Business\QuoteFacadeInterface;

class CollaborativeCartsRestApiDependencyProviderTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Quote\Business\QuoteFacadeInterface
     */
    protected $quoteFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collaborativeCartFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\CollaborativeCartsRestApiDependencyProvider
     */
    protected $collaborativeCartsRestApiDependencyProvider;

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

        $this->quoteFacadeMock = $this->getMockBuilder(QuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartFacadeMock = $this->getMockBuilder(CollaborativeCartFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsRestApiDependencyProvider = new CollaborativeCartsRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(static::atLeastOnce())
            ->method('__call')
            ->withConsecutive(['quote'], ['collaborativeCart'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->quoteFacadeMock,
                $this->collaborativeCartFacadeMock,
            );

        $container = $this->collaborativeCartsRestApiDependencyProvider->provideBusinessLayerDependencies(
            $this->containerMock,
        );

        static::assertEquals($this->containerMock, $container);

        static::assertInstanceOf(
            CollaborativeCartsRestApiToQuoteFacadeBridge::class,
            $container[CollaborativeCartsRestApiDependencyProvider::FACADE_QUOTE],
        );

        static::assertInstanceOf(
            CollaborativeCartsRestApiToCollaborativeCartFacadeBridge::class,
            $container[CollaborativeCartsRestApiDependencyProvider::FACADE_COLLABORATIVE_CART],
        );
    }
}
