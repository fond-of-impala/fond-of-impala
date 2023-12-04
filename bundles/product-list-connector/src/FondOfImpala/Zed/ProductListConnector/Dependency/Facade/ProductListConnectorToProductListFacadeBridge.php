<?php

namespace FondOfImpala\Zed\ProductListConnector\Dependency\Facade;

use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;

class ProductListConnectorToProductListFacadeBridge
{
    /**
     * @var \Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    protected $facade;

    /**
     * @param \Spryker\Zed\ProductList\Business\ProductListFacadeInterface $facade
     */
    public function __construct(ProductListFacadeInterface $facade)
    {
        $this->facade = $facade;
    }

    public function createProductList(){
        return $this->facade->createProductList();
    }
}
