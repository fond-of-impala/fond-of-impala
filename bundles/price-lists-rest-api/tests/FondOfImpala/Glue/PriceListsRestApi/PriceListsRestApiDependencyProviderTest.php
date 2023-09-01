<?php

namespace FondOfImpala\Glue\PriceListsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceList\PriceListClientInterface;
use FondOfImpala\Glue\PriceListsRestApi\Dependency\Client\PriceListsRestApiToPriceListClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Locator;
use Spryker\Glue\Kernel\Container;
use Spryker\Shared\Kernel\BundleProxy;

class PriceListsRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Locator
     */
    protected MockObject|Locator $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected MockObject|BundleProxy $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceList\PriceListClientInterface
     */
    protected MockObject|PriceListClientInterface $priceClientMock;

    /**
     * @var \FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiDependencyProvider
     */
    protected PriceListsRestApiDependencyProvider $dependencyProvider;

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

        $this->priceClientMock = $this->getMockBuilder(PriceListClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new PriceListsRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideDependencies(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('priceList')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('client')
            ->willReturn($this->priceClientMock);

        $container = $this->dependencyProvider->provideDependencies($this->containerMock);

        static::assertInstanceOf(
            PriceListsRestApiToPriceListClientInterface::class,
            $container[PriceListsRestApiDependencyProvider::CLIENT_PRICE_LIST],
        );

        static::assertCount(
            0,
            $container[PriceListsRestApiDependencyProvider::PLUGINS_FILTER_FIELDS_EXPANDER],
        );
    }
}
