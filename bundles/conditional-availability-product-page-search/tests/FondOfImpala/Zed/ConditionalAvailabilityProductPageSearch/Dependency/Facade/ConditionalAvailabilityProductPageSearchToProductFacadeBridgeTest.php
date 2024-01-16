<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ConditionalAvailabilityProductPageSearchToProductFacadeBridgeTest extends Unit
{
    protected ConditionalAvailabilityProductPageSearchToProductFacadeInterface $bridge;

    protected MockObject|ProductFacadeInterface $productFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productFacadeMock = $this->getMockBuilder(ProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityProductPageSearchToProductFacadeBridge($this->productFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetProductAbstractIdsByProductConcreteIds(): void
    {
        $productConcreteIds = [1];
        $productAbstractIds = [2];

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getProductAbstractIdsByProductConcreteIds')
            ->with($productConcreteIds)
            ->willReturn($productAbstractIds);

        static::assertEquals(
            $productAbstractIds,
            $this->bridge->getProductAbstractIdsByProductConcreteIds($productConcreteIds),
        );
    }
}
