<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PriceProductExtension\Dependency\Plugin\PriceDimensionConcreteSaverPluginInterface;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceList\PriceProductPriceListConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacadeInterface getFacade()
 */
class PriceListPriceDimensionConcreteWriterPlugin extends AbstractPlugin implements PriceDimensionConcreteSaverPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function savePrice(PriceProductTransfer $priceProductTransfer): PriceProductTransfer
    {
        return $this->getFacade()->savePriceProductPriceList($priceProductTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getDimensionName(): string
    {
        return PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST;
    }
}
