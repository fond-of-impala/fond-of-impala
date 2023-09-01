<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class PriceProductPriceListPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchDependencyProvider
     */
    protected PriceProductPriceListPageSearchDependencyProvider $priceProductPriceListPageSearchDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchDependencyProvider = new PriceProductPriceListPageSearchDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        static::assertInstanceOf(Container::class, $this->priceProductPriceListPageSearchDependencyProvider->provideServiceLayerDependencies($this->containerMock));
    }
}
