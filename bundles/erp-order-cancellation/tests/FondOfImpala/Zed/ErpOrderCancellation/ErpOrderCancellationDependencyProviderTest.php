<?php

namespace FondOfImpala\Zed\ErpOrderCancellation;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class ErpOrderCancellationDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationDependencyProvider
     */
    protected ErpOrderCancellationDependencyProvider $dependencyProvider;

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

        $this->dependencyProvider = new ErpOrderCancellationDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $container = $this->dependencyProvider
            ->provideBusinessLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);
    }
}
