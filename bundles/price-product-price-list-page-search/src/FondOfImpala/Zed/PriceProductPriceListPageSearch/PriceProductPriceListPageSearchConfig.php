<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class PriceProductPriceListPageSearchConfig extends AbstractBundleConfig
{
    /**
     * @return string|null
     */
    public function getPriceProductConcretePriceListSynchronizationPoolName(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getPriceProductAbstractPriceListSynchronizationPoolName(): ?string
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isSendingToQueue(): bool
    {
        return true;
    }
}
