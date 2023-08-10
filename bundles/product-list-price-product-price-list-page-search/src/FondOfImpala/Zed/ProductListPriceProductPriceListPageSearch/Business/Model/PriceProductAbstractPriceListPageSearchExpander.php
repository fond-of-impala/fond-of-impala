<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\Model;

use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;

class PriceProductAbstractPriceListPageSearchExpander extends AbstractPriceProductPriceListPageSearchExpander
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected function expandWithWhitelistIds(
        PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransfer
    ): PriceProductPriceListPageSearchTransfer {
        $idProductAbstract = $priceProductPriceListPageSearchTransfer->getIdProduct();

        $whitelists = $this->productListFacade->getProductWhitelistIdsByIdProductAbstract($idProductAbstract);

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
        $idProductAbstract = $priceProductPriceListPageSearchTransfer->getIdProduct();

        $blacklists = $this->productListFacade->getProductBlacklistIdsByIdProductAbstract($idProductAbstract);

        if ($blacklists) {
            $priceProductPriceListPageSearchTransfer->getProductListMap()
                ->setBlacklists($blacklists);
        }

        return $priceProductPriceListPageSearchTransfer;
    }
}
