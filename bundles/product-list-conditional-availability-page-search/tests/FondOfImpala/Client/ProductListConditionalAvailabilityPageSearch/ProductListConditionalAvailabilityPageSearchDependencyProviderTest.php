<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use Spryker\Client\Kernel\Container;

class ProductListConditionalAvailabilityPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchDependencyProvider
     */
    protected $productListConditionalAvailabilityPageSearchDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
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
    public function testProvideServiceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->productListConditionalAvailabilityPageSearchDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
