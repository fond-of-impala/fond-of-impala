<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Facade;

use Codeception\Test\Unit;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class PriceListApiToProductFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeBridge
     */
    protected $priceListApiToProductFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected $productFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productFacadeMock = $this->getMockBuilder(ProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListApiToProductFacadeBridge = new PriceListApiToProductFacadeBridge($this->productFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetProductConcreteIdsByConcreteSkus(): void
    {
        $skus = ['FOO-1'];
        $productIds = ['FOO-1' => 1];

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getProductConcreteIdsByConcreteSkus')
            ->with($skus)
            ->willReturn($productIds);

        static::assertEquals(
            $productIds,
            $this->priceListApiToProductFacadeBridge->getProductConcreteIdsByConcreteSkus($skus),
        );
    }
}
