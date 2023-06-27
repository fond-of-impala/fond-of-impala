<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridge
     */
    protected ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchFacadeInterface $facadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testPublish(): void
    {
        $conditionalAvailabilityIds = [1];
        $this->facadeMock->expects($this->atLeastOnce())
            ->method('publish')
            ->with($conditionalAvailabilityIds);

        $this->bridge->publish($conditionalAvailabilityIds);
    }
}
