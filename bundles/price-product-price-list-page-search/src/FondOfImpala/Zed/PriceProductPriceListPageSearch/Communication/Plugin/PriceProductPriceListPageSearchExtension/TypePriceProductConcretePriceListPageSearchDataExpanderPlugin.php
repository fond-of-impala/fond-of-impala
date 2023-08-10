<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension;

use FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageSearchDataExpanderPluginInterface;
use Generated\Shared\Search\PriceProductPriceListIndexMap;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory getFactory()
 */
class TypePriceProductConcretePriceListPageSearchDataExpanderPlugin extends AbstractPlugin implements PriceProductConcretePriceListPageSearchDataExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands the mapped search data.
     *
     * @api
     *
     * @param array $data
     * @param array $searchData
     *
     * @return array
     */
    public function expand(array $data, array $searchData): array
    {
        $searchData[PriceProductPriceListIndexMap::TYPE] = 'concrete';

        return $searchData;
    }
}
