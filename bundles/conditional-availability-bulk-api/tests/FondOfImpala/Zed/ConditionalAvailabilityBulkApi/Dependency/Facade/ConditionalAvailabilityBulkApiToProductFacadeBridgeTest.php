<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade;

use Codeception\Test\Unit;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ConditionalAvailabilityBulkApiToProductFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected $productFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToProductFacadeBridge
     */
    protected $facadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productFacadeMock = $this->getMockBuilder(ProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeBridge = new ConditionalAvailabilityBulkApiToProductFacadeBridge(
            $this->productFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetProductConcreteIdsByConcreteSkus(): void
    {
        $skus = ['FOO-1', 'FOO-2'];
        $ids = ['FOO-1' => 1, 'FOO-2' => 2];

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getProductConcreteIdsByConcreteSkus')
            ->with($skus)
            ->willReturn($ids);

        static::assertEquals(
            $ids,
            $this->facadeBridge->getProductConcreteIdsByConcreteSkus($skus),
        );
    }
}
