<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade;

use Codeception\Test\Unit;
use Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface;

class AllowedProductQuantitySearchToProductPageSearchFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToProductPageSearchFacadeBridge
     */
    protected $allowedProductQuantitySearchToProductPageSearchFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface
     */
    protected $productPageSearchFacadeInterface;

    /**
     * @var array
     */
    protected $productAbstractIds;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productPageSearchFacadeInterface = $this->getMockBuilder(ProductPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractIds = [

        ];

        $this->allowedProductQuantitySearchToProductPageSearchFacadeBridge = new AllowedProductQuantitySearchToProductPageSearchFacadeBridge(
            $this->productPageSearchFacadeInterface,
        );
    }

    /**
     * @return void
     */
    public function testPublish(): void
    {
        $this->allowedProductQuantitySearchToProductPageSearchFacadeBridge->publish($this->productAbstractIds);
    }

    /**
     * @return void
     */
    public function testRefresh(): void
    {
        $this->allowedProductQuantitySearchToProductPageSearchFacadeBridge->refresh($this->productAbstractIds);
    }

    /**
     * @return void
     */
    public function testUnpuhlish(): void
    {
        $this->allowedProductQuantitySearchToProductPageSearchFacadeBridge->unpublish($this->productAbstractIds);
    }
}
