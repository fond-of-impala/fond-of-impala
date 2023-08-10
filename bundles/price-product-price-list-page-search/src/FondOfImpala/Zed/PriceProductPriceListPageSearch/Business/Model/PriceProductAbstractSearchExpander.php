<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceProductAbstractSearchExpander implements PriceProductAbstractSearchExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageDataExpanderPluginInterface[]
     */
    protected $priceProductAbstractPriceListPageDataExpanderPlugins;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageDataExpanderPluginInterface[] $priceProductAbstractPriceListPageDataExpanderPlugins
     */
    public function __construct(
        array $priceProductAbstractPriceListPageDataExpanderPlugins
    ) {
        $this->priceProductAbstractPriceListPageDataExpanderPlugins = $priceProductAbstractPriceListPageDataExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    public function expand(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer {
        foreach ($this->priceProductAbstractPriceListPageDataExpanderPlugins as $priceProductAbstractPriceListPageDataExpanderPlugin) {
            $priceProductPriceListPageSearchTransfer = $priceProductAbstractPriceListPageDataExpanderPlugin->expand(
                $priceProductPriceListPageSearchTransfer,
            );
        }

        return $priceProductPriceListPageSearchTransfer;
    }
}
