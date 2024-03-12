<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi;

use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductAbstractPriceListSearchResourceMapper;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductConcretePriceListSearchResourceMapper;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductPriceListSearchResourceMapperInterface;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch\PriceProductAbstractPriceListSearchReader;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch\PriceProductConcretePriceListSearchReader;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch\PriceProductPriceListSearchReaderInterface;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Reducer\PriceDataReducerPluginExecutor;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Reducer\PriceDataReducerPluginExecutorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class PriceProductPriceListSearchRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch\PriceProductPriceListSearchReaderInterface
     */
    public function createPriceProductConcretePriceListSearchReader(): PriceProductPriceListSearchReaderInterface
    {
        return new PriceProductConcretePriceListSearchReader(
            $this->getPriceProductPriceListPageSearchClient(),
            $this->createPriceProductConcretePriceListSearchResourceMapper(),
            $this->getResourceBuilder(),
            $this->createPriceDataReducerPluginExecutor(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch\PriceProductPriceListSearchReaderInterface
     */
    public function createPriceProductAbstractPriceListSearchReader(): PriceProductPriceListSearchReaderInterface
    {
        return new PriceProductAbstractPriceListSearchReader(
            $this->getPriceProductPriceListPageSearchClient(),
            $this->createPriceProductAbstractPriceListSearchResourceMapper(),
            $this->getResourceBuilder(),
            $this->createPriceDataReducerPluginExecutor(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductPriceListSearchResourceMapperInterface
     */
    protected function createPriceProductConcretePriceListSearchResourceMapper(): PriceProductPriceListSearchResourceMapperInterface
    {
        return new PriceProductConcretePriceListSearchResourceMapper();
    }

    /**
     * @return \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Mapper\PriceProductPriceListSearchResourceMapperInterface
     */
    protected function createPriceProductAbstractPriceListSearchResourceMapper(): PriceProductPriceListSearchResourceMapperInterface
    {
        return new PriceProductAbstractPriceListSearchResourceMapper();
    }

    /**
     * @return \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Reducer\PriceDataReducerPluginExecutorInterface
     */
    protected function createPriceDataReducerPluginExecutor(): PriceDataReducerPluginExecutorInterface
    {
        return new PriceDataReducerPluginExecutor($this->getReducerPlugins());
    }

    /**
     * @return \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface
     */
    protected function getPriceProductPriceListPageSearchClient(): PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListSearchRestApiDependencyProvider::CLIENT_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH);
    }

    /**
     * @return array<\FondOfImpala\Glue\PriceProductPriceListSearchRestApiExtension\Plugin\ReducerPluginInterface>
     */
    protected function getReducerPlugins(): array
    {
        return $this->getProvidedDependency(PriceProductPriceListSearchRestApiDependencyProvider::PLUGINS_REDUCER);
    }
}
