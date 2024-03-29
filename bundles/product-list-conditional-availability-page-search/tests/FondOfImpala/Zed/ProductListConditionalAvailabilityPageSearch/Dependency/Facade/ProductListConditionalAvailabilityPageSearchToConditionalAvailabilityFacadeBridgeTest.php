<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridgeTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge $bridge;

    protected MockObject|ConditionalAvailabilityFacadeInterface $facadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityIdsByProductConcreteIds(): void
    {
        $productConcreteIds = [1];
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityIdsByProductConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($productConcreteIds);

        static::assertEquals(
            $productConcreteIds,
            $this->bridge->getConditionalAvailabilityIdsByProductConcreteIds($productConcreteIds),
        );
    }
}
