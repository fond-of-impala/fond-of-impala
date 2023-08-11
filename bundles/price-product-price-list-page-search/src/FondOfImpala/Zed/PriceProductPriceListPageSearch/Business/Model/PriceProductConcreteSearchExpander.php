<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceProductConcreteSearchExpander implements PriceProductConcreteSearchExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageDataExpanderPluginInterface[]
     */
    protected array $priceProductConcretePriceListPageDataExpanderPlugins;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductConcretePriceListPageDataExpanderPluginInterface[] $priceProductConcretePriceListPageDataExpanderPlugins
     */
    public function __construct(
        array $priceProductConcretePriceListPageDataExpanderPlugins
    ) {
        $this->priceProductConcretePriceListPageDataExpanderPlugins = $priceProductConcretePriceListPageDataExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function expand(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer {
        foreach ($this->priceProductConcretePriceListPageDataExpanderPlugins as $priceProductConcretePriceListPageDataExpanderPlugin) {
            $priceProductPriceListPageSearchTransfer = $priceProductConcretePriceListPageDataExpanderPlugin->expand(
                $priceProductPriceListPageSearchTransfer,
            );
        }

        return $priceProductPriceListPageSearchTransfer;
    }
}
