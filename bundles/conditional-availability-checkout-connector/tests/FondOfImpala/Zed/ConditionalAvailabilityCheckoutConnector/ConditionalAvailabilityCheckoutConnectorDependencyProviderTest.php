<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityCheckoutConnectorDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\ConditionalAvailabilityCheckoutConnectorDependencyProvider
     */
    protected $conditionalAvailabilityCheckoutConnectorDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
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

        $this->conditionalAvailabilityCheckoutConnectorDependencyProvider = new ConditionalAvailabilityCheckoutConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->conditionalAvailabilityCheckoutConnectorDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
