<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Spryker\Service\PriceProductExtension\Dependency\Plugin\PriceProductDimensionExpanderStrategyPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceList\PriceProductPriceListConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacadeInterface getFacade()
 */
class PriceListPriceProductDimensionExpanderStrategyPlugin extends AbstractPlugin implements PriceProductDimensionExpanderStrategyPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceProductDimensionTransfer
     *
     * @return bool
     */
    public function isApplicable(PriceProductDimensionTransfer $priceProductDimensionTransfer): bool
    {
        return $priceProductDimensionTransfer->getIdPriceList() !== null;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceProductDimensionTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    public function expand(PriceProductDimensionTransfer $priceProductDimensionTransfer): PriceProductDimensionTransfer
    {
        return $this->getFacade()->expandPriceProductDimension($priceProductDimensionTransfer);
    }
}
