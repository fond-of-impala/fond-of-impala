<?php

namespace FondOfImpala\Client\CustomerPriceList;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class CustomerPriceListDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CustomerPriceList\CustomerPriceListDependencyProvider
     */
    protected CustomerPriceListDependencyProvider $customerPriceListDependencyProvider;

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

        $this->customerPriceListDependencyProvider = new CustomerPriceListDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->assertEquals(
            $this->containerMock,
            $this->customerPriceListDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
