<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\Kernel\Container;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider
     */
    protected PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider $dependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
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

        $this->dependencyProvider = new PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->dependencyProvider->provideDependencies(
                $this->containerMock,
            ),
        );
    }
}
