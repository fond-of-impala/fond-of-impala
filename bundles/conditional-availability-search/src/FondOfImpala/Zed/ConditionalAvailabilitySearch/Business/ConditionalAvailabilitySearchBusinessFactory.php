<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business;

use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ProductConcretePageSearchExpander;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ProductConcretePageSearchExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Mapper\ProductDataToConditionalAvailabilityMapTransferMapper;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ProductPage\ProductPageDataExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\ConditionalAvailabilitySearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface;
use Spryker\Zed\ConditionalAvailabilitySearch\Business\ConditionalAvailability\ProductDataToConditionalAvailabilityMapTransferMapperInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class ConditionalAvailabilitySearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ProductConcretePageSearchExpanderInterface
     */
    public function createProductConcretePageSearchExpander(): ProductConcretePageSearchExpanderInterface
    {
        return new ProductConcretePageSearchExpander($this->getConditionalAvailabilityFacade());
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getConditionalAvailabilityFacade(): ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilitySearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ProductPage\ProductPageDataExpanderInterface
     */
    public function createProductPageDataExpander(): ProductPageDataExpanderInterface
    {
        return new ProductPageDataExpander();
    }

    /**
     * @return \Spryker\Zed\ConditionalAvailabilitySearch\Business\ConditionalAvailability\ProductDataToConditionalAvailabilityMapTransferMapperInterface
     */
    public function createProductDataToConditionalAvailabilityMapTransferMapper(): ProductDataToConditionalAvailabilityMapTransferMapperInterface
    {
        return new ProductDataToConditionalAvailabilityMapTransferMapper();
    }

}
