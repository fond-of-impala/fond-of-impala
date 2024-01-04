<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityCheckoutConnectorDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\AllowedProductQuantityCheckoutConnectorDependencyProvider
     */
    protected $allowedProductQuantityCheckoutConnectorDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityCheckoutConnectorDependencyProvider = new AllowedProductQuantityCheckoutConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(Container::class, $this->allowedProductQuantityCheckoutConnectorDependencyProvider->provideBusinessLayerDependencies($this->containerMock));
    }
}
