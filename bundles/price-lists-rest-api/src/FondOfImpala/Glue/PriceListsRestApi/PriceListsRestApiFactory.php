<?php

namespace FondOfImpala\Glue\PriceListsRestApi;

use FondOfImpala\Glue\PriceListsRestApi\Dependency\Client\PriceListsRestApiToPriceListClientInterface;
use FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListMapper;
use FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListMapperInterface;
use FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListReader;
use FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListReaderInterface;
use FondOfImpala\Glue\PriceListsRestApi\Processor\Validation\RestApiError;
use FondOfImpala\Glue\PriceListsRestApi\Processor\Validation\RestApiErrorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class PriceListsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListReaderInterface
     */
    public function createPriceListReader(): PriceListReaderInterface
    {
        return new PriceListReader(
            $this->getResourceBuilder(),
            $this->createRestApiError(),
            $this->getPriceListClient(),
            $this->createPriceListMapper(),
            $this->getFilterFieldsExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListMapperInterface
     */
    protected function createPriceListMapper(): PriceListMapperInterface
    {
        return new PriceListMapper();
    }

    /**
     * @return \FondOfImpala\Glue\PriceListsRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfImpala\Glue\PriceListsRestApi\Dependency\Client\PriceListsRestApiToPriceListClientInterface
     */
    protected function getPriceListClient(): PriceListsRestApiToPriceListClientInterface
    {
        return $this->getProvidedDependency(PriceListsRestApiDependencyProvider::CLIENT_PRICE_LIST);
    }

    /**
     * @return array<\FondOfOryx\Glue\PriceListsRestApiExtension\Dependency\Plugin\FilterFieldsExpanderPluginInterface>
     */
    protected function getFilterFieldsExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PriceListsRestApiDependencyProvider::PLUGINS_FILTER_FIELDS_EXPANDER);
    }
}
