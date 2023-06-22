<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business;

use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpander;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class ProductListConditionalAvailabilityPageSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface
     */
    public function createConditionalAvailabilityPeriodPageSearchExpander(): ConditionalAvailabilityPeriodPageSearchExpanderInterface
    {
        return new ConditionalAvailabilityPeriodPageSearchExpander(
            $this->getProductListFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface
     */
    protected function getProductListFacade(): ProductListConditionalAvailabilityPageSearchToProductListFacadeInterface
    {
        return $this->getProvidedDependency(
            ProductListConditionalAvailabilityPageSearchDependencyProvider::FACADE_PRODUCT_LIST,
        );
    }
}
