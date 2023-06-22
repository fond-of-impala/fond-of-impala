<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityCartConnectorDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorDependencyProvider
     */
    protected $conditionalAvailabilityCartConnectorDependencyProvider;

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

        $this->conditionalAvailabilityCartConnectorDependencyProvider = new ConditionalAvailabilityCartConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->conditionalAvailabilityCartConnectorDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
