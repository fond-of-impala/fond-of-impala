<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business;

use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ProductConcretePageSearchExpander;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ProductConcretePageSearchExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Mapper\ProductDataToConditionalAvailabilityMapTransferMapper;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Mapper\ProductDataToConditionalAvailabilityMapTransferMapperInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ProductPage\ProductPageDataExpander;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ProductPage\ProductPageDataExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Reader\ProductAbstractReader;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\ConditionalAvailabilitySearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class ConditionalAvailabilitySearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ProductConcretePageSearchExpanderInterface
     */
    public function createProductAbstractReader(): ProductAbstractReaderInterface
    {
        return new ProductAbstractReader($this->getProductFacade());
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Expander\ProductConcretePageSearchExpanderInterface
     */
    public function createProductConcretePageSearchExpander(): ProductConcretePageSearchExpanderInterface
    {
        return new ProductConcretePageSearchExpander($this->getConditionalAvailabilityFacade());
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\ProductPage\ProductPageDataExpanderInterface
     */
    public function createProductPageDataExpander(): ProductPageDataExpanderInterface
    {
        return new ProductPageDataExpander($this->getProductFacade(), $this->getConditionalAvailabilityFacade());
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
     * @return \FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade\ConditionalAvailabilitySearchToProductFacadeInterface
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getProductFacade(): ConditionalAvailabilitySearchToProductFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilitySearchDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return ProductDataToConditionalAvailabilityMapTransferMapperInterface
     */
    public function createProductDataToConditionalAvailabilityMapTransferMapper(): ProductDataToConditionalAvailabilityMapTransferMapperInterface
    {
        return new ProductDataToConditionalAvailabilityMapTransferMapper();
    }

}
