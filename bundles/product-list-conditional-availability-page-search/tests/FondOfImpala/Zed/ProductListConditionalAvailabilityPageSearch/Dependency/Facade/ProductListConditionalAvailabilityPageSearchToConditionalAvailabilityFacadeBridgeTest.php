<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;

class ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge
     */
    protected $productListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacadeInterfaceMock;

    /**
     * @var array<int>
     */
    protected $productConcreteIds;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityFacadeInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteIds = [1];

        $this->productListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge = new ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge(
            $this->conditionalAvailabilityFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityIdsByProductConcreteIds(): void
    {
        $this->conditionalAvailabilityFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getConditionalAvailabilityIdsByProductConcreteIds')
            ->with($this->productConcreteIds)
            ->willReturn($this->productConcreteIds);

        $this->assertIsArray(
            $this->productListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeBridge->getConditionalAvailabilityIdsByProductConcreteIds(
                $this->productConcreteIds,
            ),
        );
    }
}
