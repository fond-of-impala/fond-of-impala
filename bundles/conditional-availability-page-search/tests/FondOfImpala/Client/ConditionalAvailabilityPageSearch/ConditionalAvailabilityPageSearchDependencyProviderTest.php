<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use Spryker\Client\Kernel\Container;

class ConditionalAvailabilityPageSearchDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider
     */
    protected $conditionalAvailabilityPageSearchDependencyProvider;

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

        $this->conditionalAvailabilityPageSearchDependencyProvider = new ConditionalAvailabilityPageSearchDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->conditionalAvailabilityPageSearchDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
