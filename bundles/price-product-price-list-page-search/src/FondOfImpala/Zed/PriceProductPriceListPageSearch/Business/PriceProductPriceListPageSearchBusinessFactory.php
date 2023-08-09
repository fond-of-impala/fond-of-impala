<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business;

use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceGrouper;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceGrouperInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchExpander;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchExpanderInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchMapper;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchWriter;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchWriterInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchExpander;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchExpanderInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchMapper;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchWriter;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchWriterInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductSearchMapperInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchQueryContainerInterface getQueryContainer()
 */
class PriceProductPriceListPageSearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchWriterInterface
     */
    public function createPriceProductAbstractSearchWriter(): PriceProductAbstractSearchWriterInterface
    {
        return new PriceProductAbstractSearchWriter(
            $this->createPriceGrouper(),
            $this->createPriceProductAbstractSearchMapper(),
            $this->getUtilEncodingService(),
            $this->getRepository(),
            $this->getEntityManager(),
            $this->createPriceProductAbstractSearchExpander(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchWriterInterface
     */
    public function createPriceProductConcreteSearchWriter(): PriceProductConcreteSearchWriterInterface
    {
        return new PriceProductConcreteSearchWriter(
            $this->createPriceGrouper(),
            $this->createPriceProductConcreteSearchMapper(),
            $this->getUtilEncodingService(),
            $this->getRepository(),
            $this->getEntityManager(),
            $this->createPriceProductConcreteSearchExpander(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceGrouperInterface
     */
    protected function createPriceGrouper(): PriceGrouperInterface
    {
        return new PriceGrouper();
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductSearchMapperInterface
     */
    protected function createPriceProductAbstractSearchMapper(): PriceProductSearchMapperInterface
    {
        return new PriceProductAbstractSearchMapper(
            $this->getStoreFacade(),
            $this->getPriceProductAbstractPriceListPageSearchDataExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductSearchMapperInterface
     */
    protected function createPriceProductConcreteSearchMapper(): PriceProductSearchMapperInterface
    {
        return new PriceProductConcreteSearchMapper(
            $this->getStoreFacade(),
            $this->getPriceProductConcretePriceListPageSearchDataExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductAbstractSearchExpanderInterface
     */
    protected function createPriceProductAbstractSearchExpander(): PriceProductAbstractSearchExpanderInterface
    {
        return new PriceProductAbstractSearchExpander(
            $this->getPriceProductAbstractPriceListPageDataExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model\PriceProductConcreteSearchExpanderInterface
     */
    protected function createPriceProductConcreteSearchExpander(): PriceProductConcreteSearchExpanderInterface
    {
        return new PriceProductConcreteSearchExpander(
            $this->getPriceProductConcretePriceListPageDataExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageDataExpanderPluginInterface[]
     */
    protected function getPriceProductConcretePriceListPageDataExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_DATA_EXPANDER);
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageDataExpanderPluginInterface[]
     */
    protected function getPriceProductAbstractPriceListPageDataExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_DATA_EXPANDER);
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageSearchDataExpanderPluginInterface[]
     */
    protected function getPriceProductConcretePriceListPageSearchDataExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_CONCRETE_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER);
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface[]
     */
    protected function getPriceProductAbstractPriceListPageSearchDataExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PriceProductPriceListPageSearchDependencyProvider::PLUGINS_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PAGE_SEARCH_DATA_EXPANDER);
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceInterface
     */
    protected function getUtilEncodingService(): PriceProductPriceListPageSearchToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListPageSearchDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface
     */
    protected function getStoreFacade(): PriceProductPriceListPageSearchToStoreFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListPageSearchDependencyProvider::FACADE_STORE);
    }
}
