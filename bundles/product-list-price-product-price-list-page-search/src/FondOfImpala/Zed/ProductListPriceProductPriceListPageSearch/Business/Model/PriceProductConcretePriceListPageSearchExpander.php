<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceProductConcretePriceListPageSearchExpander extends AbstractPriceProductPriceListPageSearchExpander
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected function expandWithWhitelistIds(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer {
        $idProduct = $priceProductPriceListPageSearchTransfer->getIdProduct();

        $whitelists = $this->productListFacade->getProductWhitelistIdsByIdProduct($idProduct);

        if ($whitelists) {
            $priceProductPriceListPageSearchTransfer->getProductListMap()
                ->setWhitelists($whitelists);
        }

        return $priceProductPriceListPageSearchTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected function expandWithBlacklistIds(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer {
        $idProduct = $priceProductPriceListPageSearchTransfer->getIdProduct();

        $blacklists = $this->productListFacade->getProductBlacklistIdsByIdProduct($idProduct);

        if ($blacklists) {
            $priceProductPriceListPageSearchTransfer->getProductListMap()
                ->setBlacklists($blacklists);
        }

        return $priceProductPriceListPageSearchTransfer;
    }
}
