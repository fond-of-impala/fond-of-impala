<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ProductListConditionalAvailabilityPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchDependencyProvider
     */
    protected MockObject|ProductListConditionalAvailabilityPageSearchDependencyProvider $dependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new ProductListConditionalAvailabilityPageSearchDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->dependencyProvider->provideBusinessLayerDependencies($this->containerMock),
        );
    }

    /**
     * @return void
     */
    public function testProvideCommunicationLayerDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->dependencyProvider->provideCommunicationLayerDependencies($this->containerMock),
        );
    }
}
