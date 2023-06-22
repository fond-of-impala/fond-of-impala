<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceBridge;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class ConditionalAvailabilityPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider
     */
    protected $conditionalAvailabilityPageSearchDependencyProvider;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    protected $utilEncodingServiceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected $eventBehaviorFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(StoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->utilEncodingServiceMock = $this->getMockBuilder(UtilEncodingServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(EventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchDependencyProvider = new ConditionalAvailabilityPageSearchDependencyProvider();
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
            ->withConsecutive(['store'], ['utilEncoding'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->withConsecutive(['facade'], ['service'])
            ->willReturnOnConsecutiveCalls(
                $this->storeFacadeMock,
                $this->utilEncodingServiceMock,
            );

        $this->assertEquals(
            $this->containerMock,
            $this->conditionalAvailabilityPageSearchDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );

        $this->assertInstanceOf(
            ConditionalAvailabilityPageSearchToStoreFacadeBridge::class,
            $this->containerMock[ConditionalAvailabilityPageSearchDependencyProvider::FACADE_STORE],
        );

        $this->assertInstanceOf(
            ConditionalAvailabilityPageSearchToUtilEncodingServiceBridge::class,
            $this->containerMock[ConditionalAvailabilityPageSearchDependencyProvider::SERVICE_UTIL_ENCODING],
        );

        $this->assertCount(
            0,
            $this->containerMock[ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_DATA_EXPANDER],
        );

        $this->assertCount(
            0,
            $this->containerMock[ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_SEARCH_DATA_EXPANDER],
        );
    }

    /**
     * @return void
     */
    public function testProvideCommunicationLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('eventBehavior')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturn($this->eventBehaviorFacadeMock);

        $this->assertEquals(
            $this->containerMock,
            $this->conditionalAvailabilityPageSearchDependencyProvider->provideCommunicationLayerDependencies(
                $this->containerMock,
            ),
        );

        $this->assertInstanceOf(
            ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge::class,
            $this->containerMock[ConditionalAvailabilityPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR],
        );
    }
}
