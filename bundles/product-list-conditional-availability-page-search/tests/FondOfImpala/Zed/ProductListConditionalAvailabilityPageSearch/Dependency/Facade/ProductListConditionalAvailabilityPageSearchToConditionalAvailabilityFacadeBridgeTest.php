<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge
     */
    protected ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface
     */
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
        $this->facadeMock->expects($this->atLeastOnce())
            ->method('getConditionalAvailabilityIdsByProductConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($productConcreteIds);

        static::assertEquals(
            $productConcreteIds,
            $this->bridge->getConditionalAvailabilityIdsByProductConcreteIds($productConcreteIds),
        );
    }
}
