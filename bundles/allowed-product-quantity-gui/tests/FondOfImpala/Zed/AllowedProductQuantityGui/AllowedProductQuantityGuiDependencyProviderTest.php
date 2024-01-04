<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityGuiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityGui\AllowedProductQuantityGuiDependencyProvider
     */
    protected $allowedProductQuantityGuiDependencyProvider;

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
