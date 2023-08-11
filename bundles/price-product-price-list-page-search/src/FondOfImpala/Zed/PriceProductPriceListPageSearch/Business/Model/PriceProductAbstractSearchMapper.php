<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface;

class PriceProductAbstractSearchMapper extends AbstractPriceProductSearchMapper
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface[]
     */
    protected array $priceProductAbstractPriceListPageDataExpanderPlugins;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface $storeFacade
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface[] $priceProductAbstractPriceListPageDataExpanderPlugins
     */
    public function __construct(
        PriceProductPriceListPageSearchToStoreFacadeInterface $storeFacade,
        array $priceProductAbstractPriceListPageDataExpanderPlugins
    ) {
        parent::__construct($storeFacade);

        $this->priceProductAbstractPriceListPageDataExpanderPlugins = $priceProductAbstractPriceListPageDataExpanderPlugins;
    }

    /**
     * @param array $data
     * @param array $searchData
     *
     * @return array
     */
    protected function expandSearchData(array $data, array $searchData): array
    {
        foreach ($this->priceProductAbstractPriceListPageDataExpanderPlugins as $priceProductAbstractPriceListPageDataExpanderPlugin) {
            $searchData = $priceProductAbstractPriceListPageDataExpanderPlugin->expand($data, $searchData);
        }

        return $searchData;
    }
}
