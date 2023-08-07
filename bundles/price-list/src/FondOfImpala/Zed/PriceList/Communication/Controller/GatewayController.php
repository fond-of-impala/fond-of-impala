<?php

namespace FondOfImpala\Zed\PriceList\Communication\Controller;

use Generated\Shared\Transfer\PriceListListTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListListTransfer
     */
    public function findPriceListsAction(PriceListListTransfer $priceListListTransfer): PriceListListTransfer
    {
        return $this->getFacade()->findPriceLists($priceListListTransfer);
    }
}
