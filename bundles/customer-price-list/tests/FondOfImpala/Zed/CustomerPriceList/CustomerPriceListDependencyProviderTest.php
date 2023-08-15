<?php

namespace FondOfImpala\Zed\CustomerPriceList;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CustomerPriceListDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerPriceList\CustomerPriceListDependencyProvider
     */
    protected CustomerPriceListDependencyProvider $customerPriceListDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
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
    public function testProvidePersistenceLayerDependencies(): void
    {
        $this->assertEquals(
            $this->containerMock,
            $this->customerPriceListDependencyProvider->providePersistenceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
