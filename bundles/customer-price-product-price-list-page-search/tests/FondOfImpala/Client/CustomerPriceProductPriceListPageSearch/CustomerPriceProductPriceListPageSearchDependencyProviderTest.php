<?php

namespace FondOfImpala\Client\CustomerPriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use Spryker\Client\Kernel\Container;

class CustomerPriceProductPriceListPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CustomerPriceProductPriceListPageSearch\CustomerPriceProductPriceListPageSearchDependencyProvider
     */
    protected $customerPriceProductPriceListPageSearchDependencyProvider;

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

        $this->customerPriceProductPriceListPageSearchDependencyProvider = new CustomerPriceProductPriceListPageSearchDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->customerPriceProductPriceListPageSearchDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
