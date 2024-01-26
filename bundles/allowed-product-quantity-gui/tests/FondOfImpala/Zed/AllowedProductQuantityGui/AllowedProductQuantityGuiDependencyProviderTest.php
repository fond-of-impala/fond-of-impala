<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityGuiDependencyProviderTest extends Unit
{
    protected AllowedProductQuantityGuiDependencyProvider $allowedProductQuantityGuiDependencyProvider;

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

        $this->allowedProductQuantityGuiDependencyProvider = new AllowedProductQuantityGuiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideCommunicationLayerDependencies(): void
    {
        $this->assertInstanceOf(Container::class, $this->allowedProductQuantityGuiDependencyProvider->provideCommunicationLayerDependencies($this->containerMock));
    }
}
