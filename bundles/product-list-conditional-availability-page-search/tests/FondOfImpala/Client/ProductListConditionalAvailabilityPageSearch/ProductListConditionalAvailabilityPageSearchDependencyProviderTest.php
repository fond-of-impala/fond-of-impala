<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class ProductListConditionalAvailabilityPageSearchDependencyProviderTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchDependencyProvider $dependencyProvider;

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
    public function testProvideServiceLayerDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->dependencyProvider->provideServiceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
