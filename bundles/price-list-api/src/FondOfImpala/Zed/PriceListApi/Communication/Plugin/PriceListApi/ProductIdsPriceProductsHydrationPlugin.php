<?php

namespace FondOfImpala\Zed\PriceListApi\Communication\Plugin\PriceListApi;

use FondOfImpala\Zed\PriceListApi\Dependency\Plugin\PriceProductsHydrationPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PriceListApi\PriceListApiConfig getConfig()
 * @method \FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainerInterface getQueryContainer()
 */
class ProductIdsPriceProductsHydrationPlugin extends AbstractPlugin implements PriceProductsHydrationPluginInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function hydrate(array $priceProductTransfers): array
    {
        return $this->getFacade()->hydratePriceProductsWithProductIds($priceProductTransfers);
    }
}
