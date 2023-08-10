<?php

namespace FondOfImpala\Zed\PriceList\Business;

use FondOfImpala\Zed\PriceList\Business\Model\PriceListReader;
use FondOfImpala\Zed\PriceList\Business\Model\PriceListReaderInterface;
use FondOfImpala\Zed\PriceList\Business\Model\PriceListWriter;
use FondOfImpala\Zed\PriceList\Business\Model\PriceListWriterInterface;
use FondOfImpala\Zed\PriceList\PriceListDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\PriceList\PriceListConfig getConfig()
 * @method \FondOfImpala\Zed\PriceList\Persistence\PriceListRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface getEntityManager()
 */
class PriceListBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\PriceList\Business\Model\PriceListReaderInterface
     */
    public function createPriceListReader(): PriceListReaderInterface
    {
        return new PriceListReader(
            $this->getRepository(),
            $this->getSearchPriceListQueryExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceList\Business\Model\PriceListWriterInterface
     */
    public function createPriceListWriter(): PriceListWriterInterface
    {
        return new PriceListWriter(
            $this->getEntityManager(),
        );
    }

    /**
     * @return array<\FondOfOryx\Zed\PriceListExtension\Dependency\Plugin\SearchPriceListQueryExpanderPluginInterface>
     */
    protected function getSearchPriceListQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PriceListDependencyProvider::PLUGINS_SEARCH_PRICE_LIST_QUERY_EXPANDER);
    }
}
