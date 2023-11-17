<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductConcretePageSearchExpander;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductConcretePageSearchExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductPageLoadExpander;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductPageLoadExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGenerator;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReader;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Triggerer\StockStatusTriggerer;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Triggerer\StockStatusTriggererInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepositoryInterface getRepository()
 */
class ConditionalAvailabilityProductPageSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface
     */
    public function createProductAbstractReader(): ProductAbstractReaderInterface
    {
        return new ProductAbstractReader($this->getProductFacade());
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductConcretePageSearchExpanderInterface
     */
    public function createProductConcretePageSearchExpander(): ProductConcretePageSearchExpanderInterface
    {
        return new ProductConcretePageSearchExpander(
            $this->createStockStatusGenerator(),
            $this->getConditionalAvailabilityFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductPageLoadExpanderInterface
     */
    public function createProductPageLoadExpander(): ProductPageLoadExpanderInterface
    {
        return new ProductPageLoadExpander(
            $this->createStockStatusGenerator(),
            $this->getProductFacade(),
            $this->getConditionalAvailabilityFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator\StockStatusGeneratorInterface
     */
    protected function createStockStatusGenerator(): StockStatusGeneratorInterface
    {
        return new StockStatusGenerator();
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Triggerer\StockStatusTriggererInterface
     */
    public function createStockStatusTriggerer(): StockStatusTriggererInterface
    {
        return new StockStatusTriggerer(
            $this->createProductAbstractReader(),
            $this->getProductPageSearchFacade(),
            $this->getRepository()
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected function getConditionalAvailabilityFacade(): ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected function getProductFacade(): ConditionalAvailabilityProductPageSearchToProductFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
     */
    public function getProductPageSearchFacade(): ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_PRODUCT_PAGE_SEARCH);
    }
}
