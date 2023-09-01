<?php

namespace FondOfImpala\Client\CustomerPriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class CustomerPriceProductPriceListPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CustomerPriceProductPriceListPageSearch\CustomerPriceProductPriceListPageSearchDependencyProvider
     */
    protected CustomerPriceProductPriceListPageSearchDependencyProvider $customerPriceProductPriceListPageSearchDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
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

        $this->customerPriceProductPriceListPageSearchDependencyProvider = new CustomerPriceProductPriceListPageSearchDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->customerPriceProductPriceListPageSearchDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
