<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class ProductListConditionalAvailabilityPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchDependencyProvider
     */
    protected $productListConditionalAvailabilityPageSearchDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchDependencyProvider = new ProductListConditionalAvailabilityPageSearchDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->productListConditionalAvailabilityPageSearchDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testProvideCommunicationLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->productListConditionalAvailabilityPageSearchDependencyProvider->provideCommunicationLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
