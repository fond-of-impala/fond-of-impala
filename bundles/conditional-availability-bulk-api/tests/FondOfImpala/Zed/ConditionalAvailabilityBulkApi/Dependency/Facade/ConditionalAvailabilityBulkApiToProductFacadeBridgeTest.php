<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ConditionalAvailabilityBulkApiToProductFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Product\Business\ProductFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|ProductFacadeInterface $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToProductFacadeBridge
     */
    protected ConditionalAvailabilityBulkApiToProductFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(ProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityBulkApiToProductFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetProductConcreteIdsByConcreteSkus(): void
    {
        $skus = ['FOO-1', 'FOO-2'];
        $ids = ['FOO-1' => 1, 'FOO-2' => 2];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getProductConcreteIdsByConcreteSkus')
            ->with($skus)
            ->willReturn($ids);

        static::assertEquals(
            $ids,
            $this->bridge->getProductConcreteIdsByConcreteSkus($skus),
        );
    }
}
