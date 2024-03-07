<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridgeTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityPageSearchFacadeBridge $bridge;

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
    public function testPublishByConditionalAvailabilityIds(): void
    {
        $conditionalAvailabilityIds = [1, 2];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('publishByConditionalAvailabilityIds')
            ->with($conditionalAvailabilityIds);

        $this->bridge->publishByConditionalAvailabilityIds($conditionalAvailabilityIds);
    }
}
