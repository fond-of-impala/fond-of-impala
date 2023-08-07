<?php

namespace FondOfImpala\Zed\PriceProductPriceList;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class PriceProductPriceListDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\PriceProductPriceListDependencyProvider
     */
    protected $priceProductPriceListDependencyProvider;

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

        $this->priceProductPriceListDependencyProvider = new PriceProductPriceListDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->priceProductPriceListDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
