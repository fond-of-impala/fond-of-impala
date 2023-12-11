<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Kernel\Locator;
use Spryker\Shared\Kernel\BundleProxy;

class ConditionalAvailabilityProductPageSearchDependencyProviderTest extends Unit
{
    protected MockObject|BundleProxy $bundleProxyMock;

    protected MockObject|Container $containerMock;

    protected MockObject|CustomerClientInterface $customerClientMock;

    protected MockObject|Locator $locatorMock;

    protected ConditionalAvailabilityProductPageSearchDependencyProvider $dependencyProvider;

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

        $this->customerClientMock = $this->getMockBuilder(CustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new ConditionalAvailabilityProductPageSearchDependencyProvider();
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
            ->withConsecutive(['customer'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->withConsecutive(['client'])
            ->willReturnOnConsecutiveCalls($this->customerClientMock);

        $container = $this->dependencyProvider->provideServiceLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        static::assertInstanceOf(
            ConditionalAvailabilityProductPageSearchToCustomerClientInterface::class,
            $container[ConditionalAvailabilityProductPageSearchDependencyProvider::CLIENT_CUSTOMER],
        );
    }
}
