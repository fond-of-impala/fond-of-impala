<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ProductAbstractReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface
     */
    protected ProductAbstractReaderInterface $reader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productFacadeMock = $this
            ->getMockBuilder(ConditionalAvailabilityProductPageSearchToProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new ProductAbstractReader($this->productFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetProductAbstractIdsByConcreteIds(): void
    {
        $concretedIds = [1];
        $productAbstractIds = [1];
        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getProductAbstractIdsByProductConcreteIds')
            ->with($concretedIds)
            ->willReturn($productAbstractIds);

        static::assertEquals(
            $productAbstractIds,
            $this->reader->getProductAbstractIdsByConcreteIds($concretedIds),
        );
    }
}
