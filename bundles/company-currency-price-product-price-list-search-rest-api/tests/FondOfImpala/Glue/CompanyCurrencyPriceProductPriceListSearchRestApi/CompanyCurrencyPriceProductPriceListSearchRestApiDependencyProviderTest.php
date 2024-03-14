<?php

namespace FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\Kernel\Container;

class CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider
     */
    protected CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider $dependencyProvider;

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

        $this->dependencyProvider = new CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider();
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
