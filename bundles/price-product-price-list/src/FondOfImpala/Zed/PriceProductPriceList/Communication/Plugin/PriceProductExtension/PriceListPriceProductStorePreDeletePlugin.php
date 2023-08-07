<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PriceProductExtension\Dependency\Plugin\PriceProductStorePreDeletePluginInterface;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceList\PriceProductPriceListConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacadeInterface getFacade()
 */
class PriceListPriceProductStorePreDeletePlugin extends AbstractPlugin implements PriceProductStorePreDeletePluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idPriceProductStore
     *
     * @return void
     */
    public function preDelete(int $idPriceProductStore): void
    {
        $this->getFacade()->deletePriceProductPriceListByIdPriceProductStore($idPriceProductStore);
    }
}
