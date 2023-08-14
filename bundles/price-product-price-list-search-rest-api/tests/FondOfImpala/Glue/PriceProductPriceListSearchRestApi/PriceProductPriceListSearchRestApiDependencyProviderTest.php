<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\Container;

class PriceProductPriceListSearchRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiDependencyProvider
     */
    protected $priceProductPriceListSearchRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
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

        $this->priceProductPriceListSearchRestApiDependencyProvider = new PriceProductPriceListSearchRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->priceProductPriceListSearchRestApiDependencyProvider->provideDependencies(
                $this->containerMock,
            ),
        );
    }
}
