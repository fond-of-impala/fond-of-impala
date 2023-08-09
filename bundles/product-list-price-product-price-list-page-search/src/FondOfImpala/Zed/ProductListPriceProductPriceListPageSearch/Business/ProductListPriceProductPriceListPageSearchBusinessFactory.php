<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business;

use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductAbstractPriceListPageSearchExpander;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductConcretePriceListPageSearchExpander;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductPriceListPageSearchExpanderInterface;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeInterface;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class ProductListPriceProductPriceListPageSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductPriceListPageSearchExpanderInterface
     */
    public function createPriceProductAbstractPriceListPageSearchExpander(): PriceProductPriceListPageSearchExpanderInterface
    {
        return new PriceProductAbstractPriceListPageSearchExpander(
            $this->getProductListFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model\PriceProductPriceListPageSearchExpanderInterface
     */
    public function createPriceProductConcretePriceListPageSearchExpander(): PriceProductPriceListPageSearchExpanderInterface
    {
        return new PriceProductConcretePriceListPageSearchExpander(
            $this->getProductListFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Dependency\Facade\ProductListPriceProductPriceListPageSearchToProductListFacadeInterface
     */
    protected function getProductListFacade(): ProductListPriceProductPriceListPageSearchToProductListFacadeInterface
    {
        return $this->getProvidedDependency(
            ProductListPriceProductPriceListPageSearchDependencyProvider::FACADE_PRODUCT_LIST,
        );
    }
}
