<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridgeTest extends Unit
{
    protected MockObject|EventBehaviorFacadeInterface $facadeMock;

    protected ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(EventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testExecuteResolvedPluginsBySources(): void
    {
        $resourceNames = ['product_concrete'];
        $ids = [1, 3, 5];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('executeResolvedPluginsBySources')
            ->with($resourceNames, $ids, []);

        $this->bridge->executeResolvedPluginsBySources($resourceNames, $ids, []);
    }
}
