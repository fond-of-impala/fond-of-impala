<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ConditionalAvailabilityProductPageSearchToProductFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected ConditionalAvailabilityProductPageSearchToProductFacadeInterface $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\Spryker\Zed\Product\Business\ProductFacadeInterface
     */
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

    /**
     * @return void
     */
    public function testGetConcreteProductsByAbstractProductId(): void
    {
        $productConcreteIds = [1];
        $productAbstractId = 1;
        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->with($productAbstractId)
            ->willReturn($productConcreteIds);

        static::assertEquals(
            $productConcreteIds,
            $this->bridge->getConcreteProductsByAbstractProductId($productAbstractId),
        );
    }
}
